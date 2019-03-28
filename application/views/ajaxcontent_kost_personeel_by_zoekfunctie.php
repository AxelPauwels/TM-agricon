<div id="cal_kostperjaar" class="agricon-calculation-message-container agricon-c-m-c-large agricon-hide-this">
    <?php
    if (isset($kost_personeel)) {
        getCalculationMessage_kost_personeel($kost_personeel[0]);
    }
    ?>
</div>

<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php
    if (isset($kost_personeel)) {
        $template = array('table_open' => '<table id="kost_personeel_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $calcIcon = array(
            'data' => '<div class="trigger_showCalculation" data-toggle="tooltip" data-placement="bottom"
                 title="Toon/Verberg berekening"><i class="fas fa-calculator"></i></div>',
            'style' => 'width:20px;margin-right:10px'
        );
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading($calcIcon, 'Naam' . $sortIcon, 'Werknemers' . $sortIcon, 'Uren/dag' . $sortIcon, 'Uurloon' . $sortIcon, 'Kost/Jaar' . $sortIcon, $th_gewijzigdOp,
            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;

        foreach ($kost_personeel as $kost_persoon) {

            $rijNummer++;
            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row(
                $rijNummer,
                '<span hidden>' . $kost_persoon->naam . '</span><input id="editableInput_naam" readonly="readonly" value="' . $kost_persoon->naam . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $kost_persoon->aantalWerknemers . '</span><input id="editableInput_aantalWerknemers" readonly="readonly" value="' . $kost_persoon->aantalWerknemers . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $kost_persoon->aantalUren . '</span><input id="editableInput_aantalUren" readonly="readonly" value="' . $kost_persoon->aantalUren . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $kost_persoon->uurloon . '</span><input id="editableInput_uurloon" readonly="readonly" value="' . $kost_persoon->uurloon . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $kost_persoon->personeelKostPerJaar . '</span><input readonly="readonly" style="font-weight: 600" value="' . $kost_persoon->personeelKostPerJaar . '" >',
                $kost_persoon->gewijzigdOp_datum . ' ' . $kost_persoon->gewijzigdOp_tijd,
                ucfirst($kost_persoon->gewijzigdDoorUser),
                $kost_persoon->toegevoegdOp_datum . ' ' . $kost_persoon->toegevoegdOp_tijd,
                ucfirst($kost_persoon->toegevoegdDoorUser),
                '<div class="trigger-bewerkrij agricon-changeable-icon" data-id="' . $kost_persoon->id . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon" data-id="' . $kost_persoon->id . '" data-kostpersoneelnaam="' . $kost_persoon->naam . '"><i class="fas fa-times"></i></div>'
            );
        }
        echo $this->table->generate();
    } ?>
</div>