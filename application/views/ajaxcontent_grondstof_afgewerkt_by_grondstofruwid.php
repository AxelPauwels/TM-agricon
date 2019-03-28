<div class="form-row agricon-table-container agricon-wijzigbestaande-ajaxtable" style="position: relative">
    <span id="addNaamloosFractieLink"
          style="display: inline-block;position: absolute;cursor:pointer;right: 27px;top:30px;color:royalblue"
          data-grondstofruwid="<?php if (isset($grondstofruwid)) {
              echo $grondstofruwid;
          } ?>">Nieuwe fractie toevoegen</span>
    <div style="height: 90px;width: 100%;padding-left: 32px"><span style="color:transparent">|</span>
        <div id="MeldingError_container" style="color: darkred;font-size:14px">
            <span hidden id="percentage_innercontainer">
                <i class="fas fa-info-circle"></i> Het totaal van deze fracties is
                <span id="totaalpercentageWaarde" style="font-weight: bold"></span>%
                maar deze moet <span style="font-weight: bold">100%</span> zijn om de wijzigingen te kunnen opslaan.
            </span>
            <br>
            <span hidden id="prijs_innercontainer">
                <i class="fas fa-info-circle"></i> Het totaal van deze prijzen is
                <span id="totaalprijsWaarde" style="font-weight: bold"></span>
                maar deze moet <span style="font-weight: bold"><span id="totaalprijsDatHetMoetZijn"></span></span> zijn om de wijzigingen te kunnen opslaan.
            </span>
        </div>

        <div id="MeldingSuccess_container" style="color: darkgreen;font-size:14px">
            <span hidden id="percentage_innercontainer2">
                <i class="fas fa-info-circle"></i> Het totaal van deze fracties is
                <span style="font-weight: bold">100% </span>
            </span>
            <br>
            <span hidden id="prijs_innercontainer2">
                <i class="fas fa-info-circle"></i> Het totaal van deze prijzen is
                <span id="totaalprijsDatHetMoetZijn2" style="font-weight: bold"></span>
            </span>
        </div>

        <div hidden id="MeldingDelete_container" style="color: darkred;font-size:14px">
            <i class="fas fa-info-circle"></i> Enkel grondstoffen met percentage én prijs 0 kunnen verwijderd worden.
            <br>
            Gelieve eerst de grondstof eerst <span style="font-weight: bold">wijzigen</span> zodat de waardes <span
                    style="font-weight: bold">0</span> zijn voor wat je wil verwijderen.
        </div>
    </div>
    <input hidden id="totaalPrijs_dat_het_moet_zijn" value="<?php if (isset($totaalPrijs)) {
        echo $totaalPrijs;
    } ?>">
    <input hidden id="hiddengrondstofruwid" value="<?php if (isset($grondstofruwid)) {
        echo $grondstofruwid;
    } ?>">

    <?php
    if (isset($grondstoffenAfgewerkt)) {
        $template = array('table_open' => '<table id="grondstof_afgewerkt_pergrondstofruwid_table" class="agricon-table table table-responsive-sm table-sm table-striped noHoverAllowed tablesorter " border="0" cellpadding="4" cellspacing="0">');
        $this->table->set_template($template);

        $sortIcon = '<div class="agricon-sort-icon"><i class="fas fa-sort"></i></div>';
        $th_gewijzigdOp = ['data' => 'Gewijzigd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];
        $th_toegevoedOp = ['data' => 'Toegevoegd' . $sortIcon, 'class' => 'sorter-shortDate dateFormat-ddmmyyyy'];

        $this->table->set_heading('', 'Naam' . $sortIcon, 'Fractie %' . $sortIcon, 'Prijs/fractie' . $sortIcon, $th_gewijzigdOp,
            'Door' . $sortIcon, $th_toegevoedOp, 'Door' . $sortIcon, '', '');
        $rijNummer = 0;
        foreach ($grondstoffenAfgewerkt as $grondstof) {
            $rijNummer++;
            // <span hidden></span> gebruiken om te sorteren via tablesorter() -> de inputvelden kunnen editable gemaakt worden met jQuery
            $this->table->add_row(
                $rijNummer . '<input hidden id="notEditableInput_grondstofid' . $rijNummer . '" value="' . $grondstof->id . '" >',
                '<span hidden>' . ucfirst($grondstof->naam) . '</span><input id="editableInput_naam' . $rijNummer . '" class="naam" readonly="readonly" value="' . ucfirst($grondstof->naam) . '" onfocus="var temp_value=this.value; this.value=\'\'; this.value=temp_value">',
                '<span hidden>' . $grondstof->fractiePercentage . '</span><input data-soortwaarde="percentage" id="editableInput_fractiepercentage' . $rijNummer . '" class="domElementCounter fractie' . $rijNummer . ' " readonly="readonly" value="' . $grondstof->fractiePercentage . '" >',
                '<span hidden>' . $grondstof->aankoopPrijsPerFractie . '</span><input data-soortwaarde="prijs" id="editableInput_aankoopPrijsPerFractie' . $rijNummer . '" class="domElementCounter prijs' . $rijNummer . ' " readonly="readonly" value="' . $grondstof->aankoopPrijsPerFractie . '" >',

                $grondstof->gewijzigdOp_datum . ' ' . $grondstof->gewijzigdOp_tijd,
                ucfirst($grondstof->gewijzigdDoorUser),
                $grondstof->toegevoegdOp_datum . ' ' . $grondstof->toegevoegdOp_tijd,
                ucfirst($grondstof->toegevoegdDoorUser),
                '<div class="trigger-bewerkrij-fracties agricon-changeable-icon changeIcon' . $rijNummer . '" data-id="' . $grondstof->id . '" data-grondstofruwid="' . $grondstof->grondstofRuwId . '"><i class="fas fa-pencil-alt"></i></div>',
                '<div class="agricon-delete-icon-fracties" data-id="' . $grondstof->id . '" data-grondstofafgewerkt="' . $grondstof->naam . '" data-grondstofruwid="' . $grondstof->grondstofRuwId . '"><i class="fas fa-times"></i></div>'

            );
        }
        echo $this->table->generate();
    }
    ?>
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

    echo form_open('grondstof_afgewerkt/fractiesupdate', $dataOpen);

    $nummer = 0;
    if (isset($grondstoffenAfgewerkt)) {
        foreach ($grondstoffenAfgewerkt as $grondstof) {
            $nummer++;
            echo form_input('grondstof_afgewerkt_id_update[]', $grondstof->id, 'id="grondstof_afgewerkt_id_update' . $nummer . '" class="form-control" required="required" aria-label="categorie id"');
            echo form_input('grondstof_afgewerkt_naam_update[]', $grondstof->naam, 'id="grondstof_afgewerkt_naam_update' . $nummer . '" class="form-control" required="required" placeholder="naam" aria-label="categorie naam"');
            echo form_input('grondstof_afgewerkt_percentage_update[]', $grondstof->fractiePercentage, 'id="grondstof_afgewerkt_percentage_update' . $nummer . '" class="form-control" required="required" placeholder="percentage" aria-label="percentage "');
            echo form_input('grondstof_afgewerkt_prijs_update[]', $grondstof->aankoopPrijsPerFractie, 'id="grondstof_afgewerkt_prijs_update' . $nummer . '" class="form-control" required="required" placeholder="prijs" aria-label="prijs "');
            echo form_input('grondstof_afgewerkt_grondstofruwid_update', $grondstof->grondstofRuwId, 'id="grondstof_afgewerkt_grondstofruwid_update' . $nummer . '" class="form-control" type="number" required="required" placeholder="grondstofruwid" aria-label="grondstofruwid"');
            echo form_input('grondstof_afgewerkt_redirectview_update', "content_grondstof_afgewerkt_beheren", 'id="grondstof_afgewerkt_redirectview_update' . $nummer . '" class="form-control" type="number" required="required" placeholder="grondstofruwid" aria-label="percentage naam"');
        }
    }

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

    echo form_open('grondstof_afgewerkt/fractiesdelete', $dataOpen);
    echo form_input('grondstof_afgewerkt_id_delete', '', 'id="grondstof_afgewerkt_id_delete" class="form-control" required="required" aria-label="categorie id"');
    echo form_input('grondstof_afgewerkt_naam_delete', '', 'id="grondstof_afgewerkt_naam_delete" class="form-control" required="required" placeholder="naam" aria-label="categorie naam"');
    echo form_input('grondstof_afgewerkt_grondstofruwid_delete', '', 'id="grondstof_afgewerkt_grondstofruwid_delete" type="number" class="form-control" required="required" placeholder="grondstofruwid" aria-label="percentage naam"');
    echo form_input('grondstof_afgewerkt_redirectview_delete', "content_grondstof_afgewerkt_beheren", 'id="grondstof_afgewerkt_redirectview_delete' . $nummer . '" class="form-control" type="number" required="required" placeholder="grondstofruwid" aria-label="percentage naam"');
    echo form_input('aantal_grondstoffen_delete', '', 'id="aantal_grondstoffen_delete" class="form-control" type="number" required="required" placeholder="grondstofruwid" aria-label="percentage naam"');


    echo form_submit($dataSubmit);
    echo form_close();
    ?>
</div>