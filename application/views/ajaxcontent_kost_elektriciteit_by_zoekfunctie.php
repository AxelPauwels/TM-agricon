<div id="cal_kostperjaar" class="agricon-calculation-message-container agricon-c-m-c-large agricon-hide-this">
    <?php
    if (isset($kost_elektriciteit)) {
        getCalculationMessage_kost_elektriciteit($kost_elektriciteit[0]);
    }
    ?>
</div>

<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php
    if (isset($kost_elektriciteit)) {
        $template = array('table_open' => '<table id="kost_elektriciteit_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $calcIcon = array(
            'data' => '<div class="trigger_showCalculation" data-toggle="tooltip" data-placement="bottom"
                 title="Toon/Verberg berekening"><i class="fas fa-calculator"></i></span></div>',
            'style' => 'width:20px;margin-right:10px'
        );
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading($calcIcon, 'Naam' . $sortIcon, 'Verbruik/Jaar (Kwh)' . $sortIcon, 'Kostprijs/Kwh' . $sortIcon, 'Kost/Jaar' . $sortIcon, $th_gewijzigdOp,
            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;
        foreach ($kost_elektriciteit as $item_kost_elektriciteit) {
            $rijNummer++;
            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row($rijNummer,
                '<span hidden>' . ucfirst($item_kost_elektriciteit->naam) . '</span><input id="editableInput_naam" readonly="readonly" value="' . ucfirst($item_kost_elektriciteit->naam) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . ucfirst($item_kost_elektriciteit->verbruikPerJaarInKwh) . '</span><input id="editableInput_verbruikPerJaarInKwh" readonly="readonly" value="' . ucfirst($item_kost_elektriciteit->verbruikPerJaarInKwh) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $item_kost_elektriciteit->kostprijsPerKwh . '</span><input id="editableInput_kostprijsPerKwh" readonly="readonly" value="' . $item_kost_elektriciteit->kostprijsPerKwh . '" >',
                '<span hidden>' . $item_kost_elektriciteit->elektriciteitKostPerJaar . '</span><input readonly="readonly" style="font-weight: 600" value="' . $item_kost_elektriciteit->elektriciteitKostPerJaar . '" >',
                $item_kost_elektriciteit->gewijzigdOp_datum . ' ' . $item_kost_elektriciteit->gewijzigdOp_tijd,
                ucfirst($item_kost_elektriciteit->gewijzigdDoorUser),
                $item_kost_elektriciteit->toegevoegdOp_datum . ' ' . $item_kost_elektriciteit->toegevoegdOp_tijd,
                ucfirst($item_kost_elektriciteit->toegevoegdDoorUser),
                '<div class="trigger-bewerkrij agricon-changeable-icon" data-id="' . $item_kost_elektriciteit->id . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon" data-id="' . $item_kost_elektriciteit->id . '" data-kostelektriciteitnaam="' . $item_kost_elektriciteit->naam . '"><i class="fas fa-times"></i></div>'
            );
        }
        echo $this->table->generate();
    } ?>
</div>