<option value="0">Selecteer...</option>
<?php
$options = array();
$vorige = "";
if (isset($grondstoffen)) {
    //controleren of het isFractieCategorie is, om anders weer te geven
    if (isset($grondstoffen[0]->ruwNaam)) {
        // alle afgwerkte grondstoffen tonen
        foreach ($grondstoffen as $grondstof) {
            ?>
            <option value="<?php echo $grondstof->id ?>"><?php echo ucfirst($grondstof->ruwNaam) . " " . ucfirst($grondstof->naam); ?></option>
            <?php
        }
    }
    else {
        // enkel ruwe grondstoff tonen
        foreach ($grondstoffen as $grondstof) {
            ?>
            <option value="<?php echo $grondstof->id ?>"><?php echo ucfirst($grondstof->naam); ?></option>
            <?php
        }
    }
}

// DROPDOWN OPTIONS VOOR PRODUCT
if (isset($grondstoffen_voor_product)) {
    //controleren of het isFractieCategorie is, om anders weer te geven
    if ($grondstoffen_voor_product[0]->isFractieCategorie == 1) {
        // alle afgwerkte grondstoffen tonen
        foreach ($grondstoffen_voor_product as $grondstof) {
            ?>
            <option data-isfractie="1"
                    value="<?php echo $grondstof->id ?>"><?php echo ucfirst($grondstof->ruwNaam) . " " . ucfirst($grondstof->naam); ?></option>
            <?php
        }
    }
    else {
        // enkel ruwe grondstoff tonen
        foreach ($grondstoffen_voor_product as $grondstof) {
            ?>
            <option data-isfractie="0"
                    value="<?php echo $grondstof->id ?>"><?php echo ucfirst($grondstof->naam); ?></option>
            <?php
        }
    }
}


?>