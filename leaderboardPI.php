<?php
/**
 * Plugin Name: leaderboardPI
 * Description: Un plugin per gestire punteggi, rank e calcolo automatico del punteggio degli utenti.
 * Version: 1.0.0
 * Author: marino
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if (!defined('WPINC'))  {
    die;
}

// Includi le classi
require plugin_dir_path(__FILE__) . 'includes/class_leaderboardPI.php';
require plugin_dir_path(__FILE__) . 'includes/class_activator.php';
require plugin_dir_path(__FILE__) . 'includes/class_deactivator.php';

// Registra le funzioni di attivazione e disattivazione
register_activation_hook(__FILE__, array('LeaderboardPI_Activator', 'activate'));
register_deactivation_hook(__FILE__, array('LeaderboardPI_Deactivator', 'deactivate'));

// Crea un'istanza della classe LeaderboardPI e chiama il metodo run()
function run_leaderboard_pi() {
    $plugin_name = 'leaderboardPI';
    $version = '1.0.0';
    $plugin = new LeaderboardPI($plugin_name, $version);
}

run_leaderboard_pi();