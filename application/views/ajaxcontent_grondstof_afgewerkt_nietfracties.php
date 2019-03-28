<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable">
    <?php
    // de "selecteer..." optie verwijderen voor deze dropdowns

    if (isset($grondstof_categorieen_dropdownOptions)) {
        $i = 0;
        unset($grondstof_categorieen_dropdownOptions['']);
        foreach ($grondstof_categorieen_dropdownOptions as $key => $value) {
            if (strtolower($value) == "schors") {
                unset($grondstof_categorieen_dropdownOptions[$key]);
            }
            $i++;
        }
    }
    if (isset($eenheden_dropdownOptions)) {
        unset($eenheden_dropdownOptions['']);
    }

    if (isset($grondstoffenAfgewerkt)) {
        $template = array('table_open' => '<table id="grondstof_afgewerkt_pernietfracties_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading('', 'Naam' . $sortIcon, 'Categorie' . $sortIcon, 'Aankoopprijs' . $sortIcon, '/Per' . $sortIcon, $th_gewijzigdOp,
            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;

        foreach ($grondstoffenAfgewerkt as $grondstof) {
            $rijNummer++;

            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row($rijNummer,
                '<span hidden>' . $grondstof->naam . '</span><input id="editableInput_naam" readonly="readonly" value="' . ucfirst($grondstof->naam) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $grondstof->categorie->id . '</span>' . form_dropdown('edit_grondstof_afgewerkt_categorieid', $grondstof_categorieen_dropdownOptions, $grondstof->categorie->id, 'id="editableInput_grondstofcategorie" disabled="disabled" class="agricon-editable-dropdown form-control" required="required" '),
                '<span hidden>' . $grondstof->ruw->aankoopprijs . '</span><input id="editableInput_prijs" readonly="readonly" value="' . $grondstof->ruw->aankoopprijs . '" >',
                '<span hidden>' . $grondstof->ruw->eenheidId . '</span>' . form_dropdown('edit_grondstof_afgewerkt_eenheidid', $eenheden_dropdownOptions, $grondstof->ruw->eenheidId, 'id="editableInput_grondstofeenheid" disabled="disabled" class="agricon-editable-dropdown form-control" required="required" '),
                $grondstof->gewijzigdOp_datum . ' ' . $grondstof->gewijzigdOp_tijd,
                ucfirst($grondstof->gewijzigdDoorUser),
                $grondstof->toegevoegdOp_datum . ' ' . $grondstof->toegevoegdOp_tijd,
                ucfirst($grondstof->toegevoegdDoorUser),
                '<div class="trigger-bewerkrij-nietfracties agricon-changeable-icon" data-id="' . $grondstof->id . '" data-grondstofruwid="' . $grondstof->ruw->id . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon-nietfracties" data-id="' . $grondstof->id . '" data-grondstofafgewerktnaam="' . $grondstof->naam . '" data-grondstofruwid="' . $grondstof->ruw->id . '"><i class="fas fa-times"></i></div>'
            );
        }
        echo $this->table->generate();
    } ?>

</div>

<div hidden>
    <?php
    $dataOpen = array(
        'id' => 'form_grondstof_afgewerkt_update',
        'name' => 'form_grondstof_afgewerkt_update',
        'data-toggle' => 'validator',
        'role' => 'form');

    $dataSubmit = array(
        'id' => 'submit_grondstof_afgewerkt_update',
        'name' => 'submit_grondstof_afgewerkt_update',
        'type' => 'submit');

    echo form_open('grondstof_afgewerkt/nietfractiesupdate', $dataOpen);
    echo form_input('grondstof_afgewerkt_id_update', '', 'id="grondstof_afgewerkt_id_update" class="form-control" required="required" aria-label="Id"');
    echo form_input('grondstof_afgewerkt_grondstofruwid_update', '', 'id="grondstof_afgewerkt_grondstofruwid_update" class="form-control" required="required" aria-label="Id"');
    echo form_input('grondstof_afgewerkt_naam_update', '', 'id="grondstof_afgewerkt_naam_update" class="form-control" required="required" aria-label="Naam"');
    echo form_input('grondstof_afgewerkt_categorieid_update', '', 'id="grondstof_afgewerkt_categorieid_update" class="form-control" required="required" aria-label="Naam"');
    echo form_input('grondstof_afgewerkt_aankoopprijs_update', '', 'id="grondstof_afgewerkt_aankoopprijs_update" class="form-control" required="required" aria-label="Aankoopprijs"');
    echo form_input('grondstof_afgewerkt_aankoopprijs_eenheid_update', '', 'id="grondstof_afgewerkt_aankoopprijs_eenheid_update" class="form-control" required="required" aria-label="Eenheid"');

    echo form_submit($dataSubmit);
    echo form_close();
    ?>
</div>
<div hidden>
    <?php
    $dataOpen = array(
        'id' => 'form_grondstof_afgewerkt_delete',
        'name' => 'form_grondstof_afgewerkt_delete',
        'data-toggle' => 'validator',
        'role' => 'form');

    $dataSubmit = array(
        'id' => 'submit_grondstof_afgewerkt_delete',
        'name' => 'submit_grondstof_afgewerkt_delete',
        'type' => 'submit');

    echo form_open('grondstof_afgewerkt/nietfractiesdelete', $dataOpen);
    echo form_input('grondstof_afgewerkt_id_delete', '', 'id="grondstof_afgewerkt_id_delete" class="form-control" required="required" aria-label="categorie id"');
    echo form_input('grondstof_afgewerkt_grondstofruwid_delete', '', 'id="grondstof_afgewerkt_grondstofruwid_delete" class="form-control" required="required" aria-label="Id"');
    echo form_input('grondstof_afgewerkt_naam_delete', '', 'id="grondstof_afgewerkt_naam_delete" class="form-control" required="required" placeholder="naam" aria-label="categorie naam"');

    echo form_submit($dataSubmit);
    echo form_close();
    ?>
</div>

