<!-- leaderboard_pi_admin_display.php -->

<!-- ... -->

<form method="post" action="options.php">
    <?php settings_fields('leaderboard_pi_options'); ?>
    <!-- SQUADRA 1 -->
    <h3>SQUADRA 1: Rank<?php echo $squadra1_rank; ?></h3>
    <label>Utente 1:</label>
    <select id="squadra1_utente1" name="squadra1_utente1">
    <?php
    $users = get_users(array('fields' => array('ID', 'display_name')));
    foreach ($users as $user) {
        echo '<option value="' . $user->ID . '">' . $user->display_name . '</option>';
    }
    ?>
    </select>
    <label>Utente 2:</label>
    <select id="squadra1_utente2" name="squadra1_utente2">
    <?php
    $users = get_users(array('fields' => array('ID', 'display_name')));
    foreach ($users as $user) {
        echo '<option value="' . $user->ID . '">' . $user->display_name . '</option>';
    }
    ?>
    </select>

    <!-- SQUADRA 2 -->
    <h3>SQUADRA 2: Rank<?php echo $squadra2_rank; ?></h3>
    <label>Utente 3:</label>
    <select id="squadra2_utente1" name="squadra2_utente1">
    <?php
    $users = get_users(array('fields' => array('ID', 'display_name')));
    foreach ($users as $user) {
        echo '<option value="' . $user->ID . '">' . $user->display_name . '</option>';
    }
    ?>
    </select>
    <label>Utente 4:</label>
    <select id="squadra2_utente2" name="squadra2_utente2">
    <?php
    $users = get_users(array('fields' => array('ID', 'display_name')));
    foreach ($users as $user) {
        echo '<option value="' . $user->ID . '">' . $user->display_name . '</option>';
    }
    ?>
    </select>
    

    <!-- Pulsanti per assegnare la vittoria -->
    <input type="submit" name="submit_vittoria_squadra1" value="VITTORIA SQUADRA 1" />
    <input type="submit" name="submit_vittoria_squadra2" value="VITTORIA SQUADRA 2" />
</form>

<!-- ... -->

<form method="post" action="options.php">
    <?php settings_fields('leaderboard_pi_options'); ?>
    <h2>Punti base</h2>
    <table class="form-table">
        <tr>
            <th scope="row"><label for="punti_base_vittoria">Punti base vittoria</label></th>
            <td><input name="punti_base_vittoria" type="number" id="punti_base_vittoria" value="<?php echo esc_attr(get_option('leaderboard_pi_punti_base_vittoria')); ?>" class="regular-text"></td>
        </tr>
        <tr>
            <th scope="row"><label for="punti_base_sconfitta">Punti base sconfitta</label></th>
            <td><input name="punti_base_sconfitta" type="number" id="punti_base_sconfitta" value="<?php echo esc_attr(get_option('leaderboard_pi_punti_base_sconfitta')); ?>" class="regular-text"></td>
        </tr>
    </table>
    <p class="submit"><input type="submit" name="submit_punti_base" id="submit_punti_base" class="button button-primary" value="Salva modifiche"></p>
</form>



<h2>Assegna punti manualmente</h2>
<form method="post" action="options.php">
    <?php settings_fields('leaderboard_pi_options'); ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Utente</th>
            <td>
                <select name="user_id">
                    <?php
                    $users = get_users();
                    foreach ($users as $user) {
                        echo '<option value="' . $user->ID . '">' . $user->display_name . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row">Punti</th>
            <td><input type="number" name="manual_points" value="0" min="0" /></td>
        </tr>
    </table>
    <p class="submit">
        <input type="submit" name="submit_manual_points" class="button-primary" value="Assegna punti" />
    </p>
</form>
