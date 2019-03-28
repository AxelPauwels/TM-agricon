<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php
    // de "selecteer..." optie verwijderen voor deze dropdowns
    if (isset($folies_dropdownOptions)) {
        unset($folies_dropdownOptions['']);
    }
    if (isset($config_verpakkingskost_dropdownOptions)) {
        unset($config_verpakkingskost_dropdownOptions['']);
    }

    if (isset($producten)) {
        $template = array('table_open' => '<table id="product_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $calcIcon = array(
            'data' => '<div class="trigger_showCalculation" data-toggle="tooltip" data-placement="bottom"
                 title="klik op een prijs om de berekening te zien"><i class="fas fa-calculator"></i></div>',
            'style' => 'width:20px;margin-right:10px'
        );

        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading($calcIcon, 'Artikelcode' . $sortIcon, 'Beschrijving' . $sortIcon, 'Prijs' . $sortIcon, 'Stuks/Pallet' . $sortIcon, 'Inhoud/Zak' . $sortIcon, 'Folie' . $sortIcon, 'VerpakkingKost' . $sortIcon, 'Grondstoffen' . $sortIcon, 'ProductieKosten' . $sortIcon,
            $th_gewijzigdOp, 'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;
        foreach ($producten as $product) {
            $productieKosten_icon = '<div style="text-align:center;cursor:pointer" class="trigger-show-productiekosten" data-productid="' . $product->id . '" data-productiekostid="' . $product->productieKostId . '" data-productnaam="' . $product->artikelCode . " - " . $product->beschrijving . '"><i class="far fa-eye"></i></div>';
            $grondstoffen_icon = '<div style="text-align:center;cursor:pointer" class="trigger-show-grondstoffen" data-productid="' . $product->id . '" data-productnaam="' . $product->artikelCode . " - " . $product->beschrijving . '"><i class="far fa-eye"></i></div>';
            $prijsMetTrigger = '<div style="text-align:right;cursor:pointer" class="trigger-show-berekeningen" data-productid="' . $product->id . '" data-productiekostid="' . $product->productieKostId . '" data-productnaam="' . $product->artikelCode . " - " . $product->beschrijving . '"><span hidden>' . $product->aankoopPrijs . '</span><input id="notEditableInput_aankoopPrijs" readonly="readonly"  style="cursor:pointer;font-weight:600" value="€ ' . $product->aankoopPrijs . '" ></div>';

            $rijNummer++;
            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row($rijNummer,
                '<span hidden>' . strtoupper($product->artikelCode) . '</span><input id="editableInput_artikelcode" readonly="readonly" value="' . strtoupper($product->artikelCode) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $product->beschrijving . '</span><input id="editableInput_beschrijving" readonly="readonly" value="' . $product->beschrijving . '" >',
//                '<span hidden>' . $product->aankoopPrijs . '</span><input id="notEditableInput_aankoopPrijs" readonly="readonly" style="font-weight:600" value="' . $product->aankoopPrijs . '" >',
                $prijsMetTrigger,
                '<span hidden>' . $product->stuksPerPallet . '</span><input id="editableInput_stuksperpallet" readonly="readonly" value="' . $product->stuksPerPallet . '" >',
                '<span hidden>' . $product->inhoudPerZak . '</span><input id="editableInput_inhoudperzak" readonly="readonly" value="' . $product->inhoudPerZak . '" >',
                '<span hidden>' . $product->folieId . '</span>' . form_dropdown('edit_folieid', $folies_dropdownOptions, $product->folieId, 'id="editableInput_folieid" disabled="disabled" class="agricon-editable-dropdown form-control" required="required" '),
                '<span hidden>' . $product->verpakkingsKostId . '</span>' . form_dropdown('edit_verpakkingskostid', $config_verpakkingskost_dropdownOptions, $product->verpakkingsKostId, 'id="editableInput_verpakkingskostid" disabled="disabled" class="agricon-editable-dropdown form-control" required="required" '),
                '<span hidden>0</span>' . $grondstoffen_icon,
                '<span hidden>0</span>' . $productieKosten_icon,
                $product->gewijzigdOp_datum . ' ' . $product->gewijzigdOp_tijd,
                ucfirst($product->gewijzigdDoorUser),
                $product->toegevoegdOp_datum . ' ' . $product->toegevoegdOp_tijd,
                ucfirst($product->toegevoegdDoorUser),
                '<div class="trigger-bewerkrij agricon-changeable-icon" data-id="' . $product->id . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon" data-id="' . $product->id . '" data-productnaam="' . $product->artikelCode . ' - ' . $product->beschrijving . '"><i class="fas fa-times"></i></div>'
            );
        }
        echo $this->table->generate();
    } ?>
</div>