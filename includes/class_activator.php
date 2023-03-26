<?php

class LeaderboardPI_Activator {
    public static function activate() {
        global $wpdb;

        // Crea la tabella per i punteggi degli utenti se non esiste
        $table_name = $wpdb->prefix . 'leaderboard_pi_scores';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL,
            score int(11) NOT NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY user_id (user_id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
