<?php
/*
https://supporthost.com/wp-list-table-tutorial/
*/

if (! class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class Cacsp_Consent_Table extends WP_List_Table
{

    /**
     * Table data.
     *
     * @var array
     */
    private $table_data = array();

    public function __construct()
    {
        parent::__construct(
            array(
                'singular' => 'consent',
                'plural'   => 'consents',
                'ajax'     => false,
            )
        );
    }

    // Define table columns
    function get_columns()
    {
        $columns = array(
            'cb'               => '<input type="checkbox" />', // checkbox column for bulk actions
            'id'               => __('id', 'cookies-and-content-security-policy'),
            'time'             => __('time', 'cookies-and-content-security-policy'),
            'ip'               => __('ip', 'cookies-and-content-security-policy'),
            'accepted_cookies' => __('accepted_cookies', 'cookies-and-content-security-policy'),
            'expires'          => __('expires', 'cookies-and-content-security-policy'),
            'site'             => __('site', 'cookies-and-content-security-policy'),
        );
        return $columns;
    }

    /**
     * Sortable columns.
     */
    protected function get_sortable_columns()
    {
        $sortable_columns = array(
            'id'               => array('id', true),
            'time'             => array('time', true),
            'ip'               => array('ip', true),
            'accepted_cookies' => array('accepted_cookies', false),
            'expires'          => array('expires', true),
            'site'             => array('site', true),
        );
        return $sortable_columns;
    }

    /**
     * Bulk actions.
     */
    public function get_bulk_actions()
    {
        return array(
            'bulk-delete' => __('Delete selected', 'cookies-and-content-security-policy'),
        );
    }

    // Bind table with columns, data and all
    function prepare_items()
    {

        // Handle row delete + bulk delete first.
        $this->process_bulk_action();

        // Data
        if (isset($_POST['s'])) {
            $search           = sanitize_text_field(wp_unslash($_POST['s']));
            $this->table_data = $this->get_table_data($search);
        } else {
            $this->table_data = $this->get_table_data();
        }

        $columns = $this->get_columns();

        // Hidden columns (kept from your original code)
        $hidden = get_user_meta(
            get_current_user_id(),
            'managetoplevel_page_supporthost_list_tablecolumnshidden',
            true
        );
        $hidden = is_array($hidden) ? $hidden : array();

        $sortable = $this->get_sortable_columns();
        $primary  = 'id';

        $this->_column_headers = array($columns, $hidden, $sortable, $primary);

        usort($this->table_data, array($this, 'usort_reorder'));

        /* pagination */
        $per_page     = $this->get_items_per_page('elements_per_page', 10);
        $current_page = $this->get_pagenum();
        $total_items  = count($this->table_data);

        $this->table_data = array_slice(
            $this->table_data,
            (($current_page - 1) * $per_page),
            $per_page
        );

        $this->set_pagination_args(
            array(
                'total_items' => $total_items,
                'per_page'    => $per_page,
                'total_pages' => ceil($total_items / $per_page),
            )
        );

        $this->items = $this->table_data;
    }

    // Get table data
    private function get_table_data($search = '')
    {
        global $wpdb;

        $table = $wpdb->prefix . 'cacsp_consent';

        if (! empty($search)) {
            $like = '%' . $wpdb->esc_like($search) . '%';

            return $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM {$table}
					 WHERE ip LIKE %s
					    OR accepted_cookies LIKE %s
					    OR expires LIKE %s
					    OR time LIKE %s
					    OR site LIKE %s",
                    $like,
                    $like,
                    $like,
                    $like,
                    $like
                ),
                ARRAY_A
            );
        } else {
            return $wpdb->get_results(
                "SELECT * FROM {$table}",
                ARRAY_A
            );
        }
    }

    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'time':
            case 'ip':
            case 'accepted_cookies':
            case 'expires':
            case 'site':
            default:
                return isset($item[$column_name]) ? esc_html($item[$column_name]) : '';
        }
    }

    /**
     * Checkbox column (for bulk delete).
     */
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="consent_ids[]" value="%d" />',
            absint($item['id'])
        );
    }

    /**
     * ID column with row actions (single delete link).
     */
    function column_id($item)
    {
        $id = absint($item['id']);

        $delete_nonce = wp_create_nonce('cacsp_delete_consent_' . $id);

        $page = isset($_REQUEST['page'])
            ? sanitize_text_field(wp_unslash($_REQUEST['page']))
            : 'cacsp_settings';

        $title = '<strong>' . $id . '</strong>';

        return $title;
    }

    // Sorting function
    function usort_reorder($a, $b)
    {
        // If no sort, default to id
        $orderby = (! empty($_GET['orderby']))
            ? sanitize_text_field(wp_unslash($_GET['orderby']))
            : 'id';

        // If no order, default to desc
        $order = (! empty($_GET['order']))
            ? sanitize_text_field(wp_unslash($_GET['order']))
            : 'desc';

        $val_a = isset($a[$orderby]) ? $a[$orderby] : '';
        $val_b = isset($b[$orderby]) ? $b[$orderby] : '';

        $result = strcmp($val_a, $val_b);

        // final sort direction
        return ('asc' === $order) ? $result : -$result;
    }

    /**
     * Override table nav to inject our date-range delete form
     */
    protected function display_tablenav($which)
    {
?>
        <div class="tablenav <?php echo esc_attr($which); ?>">

            <div class="alignleft actions bulkactions">
                <?php $this->bulk_actions($which); ?>

                <?php if ($which === 'top') : ?>
                    <!-- Our custom date range delete form -->
                    <form method="post" style="display:inline-block; margin-left:1em;">
                        <?php wp_nonce_field('cacsp_delete_by_date', 'cacsp_delete_by_date_nonce'); ?>

                        <label for="from_date" style="margin-right:4px;">
                            <?php esc_html_e('From', 'cookies-and-content-security-policy'); ?>
                        </label>
                        <input type="date" name="from_date" id="from_date" style="width:150px;" />

                        <label for="to_date" style="margin:0 4px 0 1em;">
                            <?php esc_html_e('To', 'cookies-and-content-security-policy'); ?>
                        </label>
                        <input type="date" name="to_date" id="to_date" style="width:150px;" />

                        <button type="submit"
                            name="cacsp_delete_by_date"
                            class="button action"
                            style="margin-left:1em;">
                            <?php esc_html_e('Delete range', 'cookies-and-content-security-policy'); ?>
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <?php $this->extra_tablenav($which); ?>
            <?php $this->pagination($which); ?>

            <br class="clear" />
        </div>
    <?php
    }

    /**
     * Handle single-row delete and bulk delete.
     */
    public function process_bulk_action()
    {
        if (! current_user_can('manage_options')) {
            return;
        }

        global $wpdb;
        $table = $wpdb->prefix . 'cacsp_consent';

        // Single-row delete via row action
        if ('delete' === $this->current_action() && ! empty($_GET['consent_id'])) {
            $consent_id  = absint($_GET['consent_id']);
            $nonce_field = isset($_GET['_wpnonce']) ? sanitize_text_field(wp_unslash($_GET['_wpnonce'])) : '';

            if (! wp_verify_nonce($nonce_field, 'cacsp_delete_consent_' . $consent_id)) {
                wp_die(esc_html__('Security check failed.', 'cookies-and-content-security-policy'));
            }

            $wpdb->delete($table, array('id' => $consent_id), array('%d'));

            $page = isset($_REQUEST['page'])
                ? sanitize_text_field(wp_unslash($_REQUEST['page']))
                : 'cacsp_settings';

            wp_safe_redirect(
                add_query_arg(
                    array(
                        'page'       => $page,
                        'deleted'    => 1,
                        'deleted_id' => $consent_id,
                    ),
                    admin_url('admin.php')
                )
            );
            exit;
        }

        // Bulk delete
        if (
            (isset($_POST['action']) && 'bulk-delete' === $_POST['action']) ||
            (isset($_POST['action2']) && 'bulk-delete' === $_POST['action2'])
        ) {
            // Use our explicit nonce instead of WP_List_Table's implicit one
            check_admin_referer('cacsp_bulk_delete', 'cacsp_bulk_nonce');

            $ids = isset($_POST['consent_ids']) ? (array) $_POST['consent_ids'] : array();
            $ids = array_map('absint', $ids);
            $ids = array_filter($ids);

            if (! empty($ids)) {
                foreach ($ids as $id) {
                    $wpdb->delete($table, array('id' => $id), array('%d'));
                }
            }
        }
    }
}

/**
 * Page callback.
 */
function cacsp_consent_init()
{
    if (! current_user_can('manage_options')) {
        return;
    }

    global $wpdb;

    // Handle delete by date span BEFORE preparing items.
    if (isset($_POST['cacsp_delete_by_date'])) {
        check_admin_referer('cacsp_delete_by_date', 'cacsp_delete_by_date_nonce');

        $from = isset($_POST['from_date']) ? sanitize_text_field(wp_unslash($_POST['from_date'])) : '';
        $to   = isset($_POST['to_date']) ? sanitize_text_field(wp_unslash($_POST['to_date'])) : '';

        if ($from && $to) {
            $table_name = $wpdb->prefix . 'cacsp_consent';

            // Assume "time" is DATETIME in MySQL. Use full day boundaries.
            $from_datetime = $from . ' 00:00:00';
            $to_datetime   = $to . ' 23:59:59';

            $wpdb->query(
                $wpdb->prepare(
                    "DELETE FROM {$table_name} WHERE time >= %s AND time <= %s",
                    $from_datetime,
                    $to_datetime
                )
            );
        }
    }

    $table = new Cacsp_Consent_Table();

    echo '<div class="wrap">';

    echo '<h2>' . esc_html__('Consent', 'cookies-and-content-security-policy') . '</h2  >';

    // Date range delete form.
    ?>

    <?php

    // Main table form (search + bulk actions + table).
    ?>
    <form method="post">
        <input type="hidden" name="page" value="<?php echo isset($_REQUEST['page']) ? esc_attr(wp_unslash($_REQUEST['page'])) : 'cacsp_settings'; ?>" />
        <?php
        wp_nonce_field('cacsp_bulk_delete', 'cacsp_bulk_nonce');
        $table->prepare_items();
        $table->search_box('search', 'search_id');
        $table->display();
        ?>
    </form>
    <?php

    echo '</div>';
    ?><script>
        document.addEventListener("DOMContentLoaded", function() {
            const from = document.getElementById("from_date");
            const to = document.getElementById("to_date");

            if (from && to) {
                from.addEventListener("change", function() {
                    to.min = from.value; // disallow any earlier dates
                });

                to.addEventListener("change", function() {
                    if (to.value < from.value) {
                        to.value = from.value; // auto-correct invalid range
                    }
                });
            }
        });
    </script>
<?php
}

cacsp_consent_init();
