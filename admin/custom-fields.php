<div class="inside im-form-table">
    <div>
        <label>
            <span>Restourant Name: </span> 
            <input type="text" name="restaurant_name" value="<?php echo $restaurantName; ?>" /> 
        </label>
    </div>
    <div>
        <label>
            <span>Start Date: </span>
            <input type="text" id="start_date" name="start_date" value="<?php echo $startDate; ?>" /> 
        </label>
    </div>
    <div>
        <label>
            <span>End Date: </span>
            <input type="text" id="end_date" name="end_date" value="<?php echo $endDate; ?>" /> 
        </label>
    </div>
    <div>
        <label>
            <span>Total: </span>
            <input type="text" name="total" value="<?php echo $total; ?>" /> 
        </label>
    </div>
    <div>
        <label>
            <span>Fees: </span>
            <input type="text" name="fees" value="<?php echo $fees; ?>" /> 
        </label>
    </div>
    <div>
        <label>
            <span>Transfer: </span>
            <input type="text" name="transfer" value="<?php echo $transfer; ?>" /> 
        </label>
    </div>
    <div>
        <label>
            <span>Order: </span>
            <input type="text" name="order" value="<?php echo $order; ?>" /> 
        </label>
    </div>
    <div>
        <label>
            <span>Status: </span>
            <select name="status">
            <?php foreach($options as $option): ?>
                <option <?php echo ($status==$option)?'selected':'';?> value="<?php echo $option;?>"><?php echo strtoupper($option);?></option>
            <?php endforeach; ?>
            </select>
        </label>
    </div>
</div>