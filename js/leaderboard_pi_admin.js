jQuery(document).ready(function ($) {
    function updateTeamRank(teamNumber) {
                var user1Select = $("#squadra" + teamNumber + "_utente1");
        var user2Select = $("#squadra" + teamNumber + "_utente2");
        var rankDisplay = $("#rank_squadra" + teamNumber);

        var user1Id = user1Select.val();
        var user2Id = user2Select.val();

        $.post(leaderboard_pi_ajax.ajax_url, {
            action: 'calculate_team_rank',
            user_id_1: user1Id,
            user_id_2: user2Id
        }, function (response) {
            var data = JSON.parse(response);
            if (data.error) {
                alert(data.error);
            } else {
                rankDisplay.text('Rank Squadra ' + teamNumber + ': ' + data.team_rank);
            }
        });
    }

    $("#squadra1_utente1, #squadra1_utente2").on('change', function () {
        updateTeamRank(1);
    });

    $("#squadra2_utente1, #squadra2_utente2").on('change', function () {
        updateTeamRank(2);
    });

    // Aggiorna i rank delle squadre al caricamento della pagina
    updateTeamRank(1);
    updateTeamRank(2);
});
