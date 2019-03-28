<div id="cal_kostperjaar" class="agricon-calculation-message-container agricon-c-m-c-large agricon-hide-this">
    <?php
    if (isset($kost_machines)) {
        getCalculationMessage_kost_machines($kost_machines[0]);
    }
    ?>
</div>

<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php
    // de "selecteer..." optie verwijderen voor deze dropdowns
    if (isset($machineSoorten_dropdownOptions)) {
        unset($machineSoorten_dropdownOptions['']);
    }

    if (isset($kost_machines)) {
        $template = array('table_open' => '<table id="kost_machines_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $calcIcon = array(
            'data' => '<div style="position: relative" class="trigger_showCalculation" data-toggle="tooltip" data-placement="bottom"
                 title="Toon/Verberg berekening"><i class="fas fa-calculator"></i></div>',
            'style' => 'width:20px;margin-right:10px'
        );
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading($calcIcon, 'Naam', 'Soort' . $sortIcon, 'Aankoopprijs' . $sortIcon, 'Aantal' . $sortIcon, 'Afschrijfperiode' . $sortIcon, 'AfschrijfKost/jaar' . $sortIcon,
            'Onderhoud frequentie' . $sortIcon, 'Onderhoud kost' . $sortIcon, 'Onderhoud uren' . $sortIcon, 'Onderhoud uurloon' . $sortIcon, 'OnderhoudKost/Jaar' . $sortIcon,
            'ReparatieKost/Jaar' . $sortIcon, 'Reparaties' . $sortIcon, 'TotaalKost/jaar' . $sortIcon, $th_gewijzigdOp,
            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;


        foreach ($kost_machines as $kost_machine) {
            $eyeIcon = '<div style="text-align:center;cursor:pointer" class="trigger-show-reparaties" data-machineid="' . $kost_machine->id . '" data-machinenaam="' . $kost_machine->naam . '"><i class="far fa-eye"></i></div>';
            $rijNummer++;

            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row(
                '<span class="disable-table-sorter">' . $rijNummer . '</span>',
                '<span hidden>' . $kost_machine->naam . '</span><input id="editableInput_naam" readonly="readonly" value="' . ucfirst($kost_machine->naam) . '" >',

                '<span hidden>' . $kost_machine->machineSoortId . '</span>' . form_dropdown('edit_machine_soort_machinesoortid', $machineSoorten_dropdownOptions, $kost_machine->machineSoortId, 'id="editableInput_machinesoortid" disabled="disabled" class="agricon-editable-dropdown form-control" required="required" '),
                '<span hidden>' . $kost_machine->aankoopPrijs . '</span><input id="editableInput_aankoopPrijs" readonly="readonly" value="' . $kost_machine->aankoopPrijs . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $kost_machine->aantal . '</span><input id="editableInput_aantal" readonly="readonly" value="' . $kost_machine->aantal . '" >',
                '<span hidden>' . $kost_machine->afschrijfperiodePerJaar . '</span><input id="editableInput_afschrijfperiodePerJaar" readonly="readonly" value="' . $kost_machine->afschrijfperiodePerJaar . '" >',
                '<span hidden>' . $kost_machine->afschrijfperiodeKostPerJaar . '</span><input id="ReadOnlyInput_afschrijfperiodeKostPerJaar" readonly="readonly" style="font-weight: 600" value="' . $kost_machine->afschrijfperiodeKostPerJaar . '" >',

                '<span hidden>' . $kost_machine->onderhoudFrequentiePerJaar . '</span><input id="editableInput_onderhoudFrequentiePerJaar" readonly="readonly" value="' . $kost_machine->onderhoudFrequentiePerJaar . '" >',
                '<span hidden>' . $kost_machine->onderhoudKost . '</span><input id="editableInput_onderhoudKost" readonly="readonly" value="' . $kost_machine->onderhoudKost . '" >',
                '<span hidden>' . $kost_machine->onderhoudUren . '</span><input id="editableInput_onderhoudUren" readonly="readonly" value="' . $kost_machine->onderhoudUren . '" >',
                '<span hidden>' . $kost_machine->onderhoudUurloon . '</span><input id="editableInput_onderhoudUurloon" readonly="readonly" value="' . $kost_machine->onderhoudUurloon . '" >',
                '<span hidden>' . $kost_machine->onderhoudKostPerJaar . '</span><input id="ReadOnlyInput_onderhoudKostPerJaar" readonly="readonly" style="font-weight: 600" value="' . $kost_machine->onderhoudKostPerJaar . '" >',

                '<span hidden>' . $kost_machine->reparatieKostPerJaar . '</span><input id="ReadOnlyInput_reparatieKostPerJaar" readonly="readonly" style="font-weight: 600" value="' . $kost_machine->reparatieKostPerJaar . '" >',
                $eyeIcon,
                '<span hidden>' . $kost_machine->totaalMachineKostPerJaar . '</span><input id="ReadOnlyInput_totaalMachineKostPerJaar" readonly="readonly" style="font-weight: 600" value="' . $kost_machine->totaalMachineKostPerJaar . '" >',

                $kost_machine->gewijzigdOp_datum . ' ' . $kost_machine->gewijzigdOp_tijd,
                ucfirst($kost_machine->gewijzigdDoorUser),
                $kost_machine->toegevoegdOp_datum . ' ' . $kost_machine->toegevoegdOp_tijd,
                ucfirst($kost_machine->toegevoegdDoorUser),
                '<div class="trigger-bewerkrij agricon-changeable-icon" data-id="' . $kost_machine->id . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon" data-id="' . $kost_machine->id . '" data-kostmachinenaam="' . $kost_machine->naam . '"><i class="fas fa-times"></i></div>'
            );
        }
        echo $this->table->generate();
    } ?>
</div>