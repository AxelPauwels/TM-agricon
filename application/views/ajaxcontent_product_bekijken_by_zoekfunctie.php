<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php

    if (isset($producten)) {
        $template = array('table_open' => '<table id="product_bekijken_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
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
            $th_gewijzigdOp, 'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon);
        $rijNummer = 0;
        foreach ($producten as $product) {
            $productieKosten_icon = '<div style="text-align:center;cursor:pointer" class="trigger-show-productiekosten" data-productid="' . $product->id . '" data-productiekostid="' . $product->productieKostId . '" data-productnaam="' . $product->artikelCode . " - " . $product->beschrijving . '"><i class="far fa-eye"></i></div>';
            $grondstoffen_icon = '<div style="text-align:center;cursor:pointer" class="trigger-show-grondstoffen" data-productid="' . $product->id . '" data-productnaam="' . $product->artikelCode . " - " . $product->beschrijving . '"><i class="far fa-eye"></i></div>';
            $prijsMetTrigger = '<div style="text-align:right;cursor:pointer" class="trigger-show-berekeningen" data-productid="' . $product->id . '" data-productiekostid="' . $product->productieKostId . '" data-productnaam="' . $product->artikelCode . " - " . $product->beschrijving . '"><span hidden>' . $product->aankoopPrijs . '</span><input class="notEditableInput_aankoopPrijs" readonly="readonly"  style="cursor:pointer;font-weight:600" value="€ ' . $product->aankoopPrijs . '" ></div>';

            $rijNummer++;
            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row($rijNummer,
                '<span hidden>' . strtoupper($product->artikelCode) . '</span>' . strtoupper($product->artikelCode),
                '<span hidden>' . $product->beschrijving . '</span>' . $product->beschrijving,
                $prijsMetTrigger,
                '<span hidden>' . $product->stuksPerPallet . '</span>' . $product->stuksPerPallet,
                '<span hidden>' . $product->inhoudPerZak . '</span>' . $product->inhoudPerZak,
                '<span hidden>' . $product->folie . '</span>' . $product->folie,
                '<span hidden>' . $product->verpakkingskost . '</span>' . $product->verpakkingskost,
                '<span hidden>0</span>' . $grondstoffen_icon,
                '<span hidden>0</span>' . $productieKosten_icon,
                $product->gewijzigdOp_datum . ' ' . $product->gewijzigdOp_tijd,
                ucfirst($product->gewijzigdDoorUser),
                $product->toegevoegdOp_datum . ' ' . $product->toegevoegdOp_tijd,
                ucfirst($product->toegevoegdDoorUser)
            );
        }
        echo $this->table->generate();
    } ?>
</div>