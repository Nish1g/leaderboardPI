<?php
class LeaderboardPI {
    // Il costruttore verrà utilizzato per inizializzare gli hook di WordPress
 public function __construct($plugin_name, $version) {
    $this->plugin_name = $plugin_name;
    $this->version = $version;

    add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
    add_action('admin_init', array($this, 'register_mysettings'));
    add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    add_action('wp_ajax_calculate_team_rank', array($this, 'ajax_calculate_team_rank'));
}






    public function add_plugin_admin_menu() {
        // Aggiungi il menu principale del plugin
        add_menu_page('Leaderboard Padel Indoor', 'Leaderboard Padel Indoor', 'manage_options', 'leaderboard_pi', array($this, 'display_plugin_admin_page'));
    
        // Aggiungi la pagina di sottomenu per la classifica degli utenti
        add_submenu_page('leaderboard_pi', 'Classifica', 'Classifica', 'manage_options', 'leaderboard_pi_classifica', array($this, 'display_user_leaderboard'));
    }



    private function handle_punti_base_form() {
        if (isset($_POST['submit_punti_base'])) {
            // Gestisci i dati inviati dal form dei punti base
            // Aggiorna i punteggi nel database di WordPress
    
            // Sanifica e salva i valori inviati nel form
            $punti_base_vittoria = intval(sanitize_text_field($_POST['punti_base_vittoria']));
            $punti_base_sconfitta = intval(sanitize_text_field($_POST['punti_base_sconfitta']));
    
            // Aggiorna le opzioni nel database di WordPress
            update_option('leaderboard_pi_punti_base_vittoria', $punti_base_vittoria);
            update_option('leaderboard_pi_punti_base_sconfitta', $punti_base_sconfitta);
    
            // Mostra un messaggio di conferma
            echo '<div class="updated"><p><strong>Impostazioni salvate.</strong></p></div>';
        }
    }

   private function handle_squadre_form() {
        if (isset($_POST['submit_vittoria_squadra1']) || isset($_POST['submit_vittoria_squadra2'])) {
            // Gestisci i dati inviati dal form delle squadre
            // Calcola il rank delle squadre e aggiorna i punteggi degli utenti
    
            // Esempio: Recupera gli ID degli utenti selezionati nel form
            $squadra1_utente1 = intval($_POST['squadra1_utente1']);
            $squadra1_utente2 = intval($_POST['squadra1_utente2']);
            $squadra2_utente1 = intval($_POST['squadra2_utente1']);
            $squadra2_utente2 = intval($_POST['squadra2_utente2']);
    
            // Recupera i punteggi degli utenti dal database e calcola il rank delle squadre
            $punti_base_vittoria = intval(get_option('leaderboard_pi_punti_base_vittoria'));
            $punti_base_sconfitta = intval(get_option('leaderboard_pi_punti_base_sconfitta'));
    
           // Determina quale squadra ha vinto e aggiorna i punteggi degli utenti
        if (isset($_POST['submit_vittoria_squadra1'])) {
            // La squadra 1 ha vinto, aggiorna i punteggi degli utenti
            $this->update_user_score($squadra1_utente1, $punti_base_vittoria);
            $this->update_user_score($squadra1_utente2, $punti_base_vittoria);
            $this->update_user_score($squadra2_utente1, $punti_base_sconfitta);
            $this->update_user_score($squadra2_utente2, $punti_base_sconfitta);
        } else {
            // La squadra 2 ha vinto, aggiorna i punteggi degli utenti
            $this->update_user_score($squadra1_utente1, $punti_base_sconfitta);
            $this->update_user_score($squadra1_utente2, $punti_base_sconfitta);
            $this->update_user_score($squadra2_utente1, $punti_base_vittoria);
            $this->update_user_score($squadra2_utente2, $punti_base_vittoria);
        }

        // Mostra un messaggio di conferma
        echo '<div class="updated"><p><strong>Risultato salvato.</strong></p></div>';
    }
}


private function get_rank($points) {
    if ($points >= 3001) {
        return 'S';
    } elseif ($points >= 2001) {
        return 'A';
    } elseif ($points >= 1401) {
        return 'B';
    } elseif ($points >= 901) {
        return 'C';
    } elseif ($points >= 501) {
        return 'D';
    } elseif ($points >= 201) {
        return 'E';
    } else {
        return 'F';
    }
}


public function ajax_calculate_team_rank() {
    if (!isset($_POST['user_id_1']) || !isset($_POST['user_id_2'])) {
        echo json_encode(array('error' => 'Invalid input'));
        wp_die();
    }

    $user_id_1 = intval($_POST['user_id_1']);
    $user_id_2 = intval($_POST['user_id_2']);

    $team_rank = $this->calculate_team_rank($user_id_1, $user_id_2);

    echo json_encode(array('team_rank' => $team_rank));
    wp_die();
}


public function enqueue_scripts($hook) {
    if ($hook != 'toplevel_page_leaderboard_pi') {
        return;
    }

    wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/leaderboard_pi_admin.js', array('jquery'), $this->version, false);
    wp_localize_script($this->plugin_name, 'leaderboard_pi_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
}





private function calculate_team_rank($user_id1, $user_id2) {
    $user1_points = get_user_meta($user_id1, 'leaderboard_pi_punti', true);
    $user2_points = get_user_meta($user_id2, 'leaderboard_pi_punti', true);

    if (!$user1_points) {
        $user1_points = 0;
    }

    if (!$user2_points) {
        $user2_points = 0;
    }

    $team_rank = ($user1_points + $user2_points) / 2;

    return $team_rank;
}



private function handle_manual_points_form() {
    if (isset($_POST['submit_manual_points'])) {
        $user_id = intval($_POST['user_id']);
        $points = intval(sanitize_text_field($_POST['manual_points']));

        $this->update_user_score($user_id, $points);

        echo '<div class="updated"><p><strong>Punti assegnati manualmente.</strong></p></div>';
    }
}




private function update_user_score($user_id, $points) {
    error_log("update_user_score() called with user_id: {$user_id}, points: {$points}");
    // Recupera il punteggio attuale dell'utente
    $current_score = get_user_meta($user_id, 'leaderboard_pi_punti', true);

    // Se l'utente non ha un punteggio, imposta il punteggio corrente a 0
    if (!$current_score) {
        $current_score = 0;
    }

    // Calcola il nuovo punteggio
    $new_score = $current_score + $points;

    // Aggiorna il punteggio dell'utente nel database
    update_user_meta($user_id, 'leaderboard_pi_punti', $new_score);
}




public function register_mysettings() {
    // Registra le impostazioni del plugin qui
    register_setting('leaderboard_pi_options', 'leaderboard_pi_punti_base_vittoria');
    register_setting('leaderboard_pi_options', 'leaderboard_pi_punti_base_sconfitta');
}




public function display_user_leaderboard() {
    // Recupera gli utenti e ordina per punti (meta_key 'leaderboard_pi_punti') in ordine decrescente
    $args = array(
    'meta_key' => 'leaderboard_pi_punti',
    'orderby' => 'meta_value_num',
    'order' => 'DESC'
    //'fields' => 'all_with_meta'
);
    $users = get_users($args);

    // Visualizza la tabella
    echo '<table class="widefat fixed" cellspacing="0">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Posizione</th>';
    echo '<th>Nome utente</th>';
    echo '<th>Punti</th>';
    echo '<th>Rank</th>'; // Aggiungi una colonna "Rank"
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    $rank = 1;
    foreach ($users as $user) {
        $punti = get_user_meta($user->ID, 'leaderboard_pi_punti', true);
        $user_rank = $this->get_rank($punti); // Ottieni il rank dell'utente in base ai punti
        echo '<tr>';
        echo '<td>' . $rank . '</td>';
        echo '<td>' . $user->display_name . '</td>';
        echo '<td>' . $punti . '</td>';
        echo '<td>' . $user_rank . '</td>'; // Visualizza il rank dell'utente
        echo '</tr>';
        $rank++;
    }

    echo '</tbody>';
    echo '</table>';
}


    public function display_plugin_admin_page() {
    // Controlla i permessi dell'utente
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    // Gestisci i dati inviati dai form
    $this->handle_punti_base_form();
    $this->handle_squadre_form();
    $this->handle_manual_points_form();

    // Recupera gli ID degli utenti selezionati nel form
    $squadra1_utente1 = isset($_POST['squadra1_utente1']) ? intval($_POST['squadra1_utente1']) : 0;
    $squadra1_utente2 = isset($_POST['squadra1_utente2']) ? intval($_POST['squadra1_utente2']) : 0;
    $squadra2_utente1 = isset($_POST['squadra2_utente1']) ? intval($_POST['squadra2_utente1']) : 0;
    $squadra2_utente2 = isset($_POST['squadra2_utente2']) ? intval($_POST['squadra2_utente2']) : 0;

    // Calcola i rank delle squadre
    $squadra1_rank = $this->calculate_team_rank($squadra1_utente1, $squadra1_utente2);
    $squadra2_rank = $this->calculate_team_rank($squadra2_utente1, $squadra2_utente2);

    // Includi il file HTML per il contenuto della pagina di amministrazione
    require_once plugin_dir_path(__FILE__) . 'partials/leaderboard_pi_admin_display.php';
}
}