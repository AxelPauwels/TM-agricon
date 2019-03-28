<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <p class="text-muted" style="font-size: 12px;padding-left:33px">Het geëncrypteerd wachtwoord kan gewijzigd worden
        met een normaal leesbaar nieuw wachtwoord.
        <br>Na het bevestigen van deze wijziging wordt het wachtwoord geëncrypteerd opgeslagen.</p>
    <?php
    // de "selecteer..." optie verwijderen voor deze dropdowns
    if (isset($userLevel_dropdownOptions)) {
        unset($userLevel_dropdownOptions['']);
    }

    if (isset($users)) {
        $template = array('table_open' => '<table id="users_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading('', 'Naam' . $sortIcon, 'Niveau' . $sortIcon, 'Geëncrypteerd wachtwoord' . $sortIcon,
            'Actief sinds' . $sortIcon, '', '');
        $rijNummer = 0;
        foreach ($users as $user) {
            $rijNummer++;
            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row($rijNummer,
                '<span hidden>' . $user->naam . '</span><input class="editableInput_naam" readonly="readonly" value="' . $user->naam . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $user->level . '</span>' . form_dropdown('edit_user_level', $userLevel_dropdownOptions, intval($user->level), ' disabled="disabled" class="editableInput_level agricon-editable-dropdown form-control" required="required" '),
                '<span hidden>' . $user->wachtwoord . '</span><input class="editableInput_wachtwoord" readonly="readonly" value="' . $user->wachtwoord . '" >',
                $user->actief_datum . ' ' . $user->actief_tijd,
                '<div class="trigger-bewerkrij agricon-changeable-icon" data-id="' . $user->id . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon" data-id="' . $user->id . '" data-usernaam="' . $user->naam . '"><i class="fas fa-times"></i></div>'
            );
        }
        echo $this->table->generate();
    } ?>
</div>