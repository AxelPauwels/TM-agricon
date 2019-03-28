<div id="cal_kostperjaar" class="agricon-calculation-message-container agricon-c-m-c-large agricon-hide-this">
    <?php
    if (isset($kost_gebouwen)) {
        getCalculationMessage_kost_gebouwen($kost_gebouwen[0]);
    }
    ?>
</div>

<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php
    if (isset($kost_gebouwen)) {
        $template = array('table_open' => '<table id="kost_gebouwen_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $calcIcon = array(
            'data' => '<div class="trigger_showCalculation" data-toggle="tooltip" data-placement="bottom"
                 title="Toon/Verberg berekening"><i class="fas fa-calculator"></i></div>',
            'style' => 'width:20px;margin-right:10px'
        );
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading($calcIcon, 'Naam' . $sortIcon, 'Aankoopprijs' . $sortIcon, 'Afschrijfperiode' . $sortIcon, 'Kost/Jaar' . $sortIcon, $th_gewijzigdOp,
            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;

        foreach ($kost_gebouwen as $kost_gebouw) {

            $rijNummer++;
            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row($rijNummer,
                '<span hidden>' . $kost_gebouw->naam . '</span><input id="editableInput_naam" readonly="readonly" value="' . $kost_gebouw->naam . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $kost_gebouw->aankoopPrijs . '</span><input id="editableInput_aankoopPrijs" readonly="readonly" value="' . $kost_gebouw->aankoopPrijs . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $kost_gebouw->afschrijfperiodePerJaar . '</span><input id="editableInput_afschrijfperiodePerJaar" readonly="readonly" value="' . $kost_gebouw->afschrijfperiodePerJaar . '" >',
                '<span hidden>' . $kost_gebouw->gebouwKostPerJaar . '</span><input readonly="readonly" style="font-weight: 600" value="' . $kost_gebouw->gebouwKostPerJaar . '" >',
                $kost_gebouw->gewijzigdOp_datum . ' ' . $kost_gebouw->gewijzigdOp_tijd,
                ucfirst($kost_gebouw->gewijzigdDoorUser),
                $kost_gebouw->toegevoegdOp_datum . ' ' . $kost_gebouw->toegevoegdOp_tijd,
                ucfirst($kost_gebouw->toegevoegdDoorUser),
                '<div class="trigger-bewerkrij agricon-changeable-icon" data-id="' . $kost_gebouw->id . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon" data-id="' . $kost_gebouw->id . '" data-kostgebouwennaam="' . $kost_gebouw->naam . '"><i class="fas fa-times"></i></div>'
            );
        }
        echo $this->table->generate();
    } ?>
</div>