<?php 
    //Get entire array
    $imOptions = get_option('im_options');
    $currencyCode = ($imOptions && $imOptions['currency_code']) ? $imOptions['currency_code'] : '';
    $currentPosition = ($imOptions && $imOptions['current_position']) ? $imOptions['current_position'] : '';
?>
<div class="wrap" >
    <?php if($success):?>
    <div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible"> 
        <p><strong>Settings saved.</strong></p>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text">Dismiss this notice.</span>
        </button>
    </div>
    <?php endif;?>
    <h1>Invoice Settings</h1>
    <form action="" method="POST">
        <p>
            <label> Currency Code : 
                <input type="text" name="currency_code" value="<?php echo $currencyCode; ?>" />
            </label>
        </p>
        <p>
            <label> Currency Position : 
                <select name="current_position">
                    <option value="left" <?php echo ($currentPosition == 'left')? 'selected':''; ?> >LEFT</option>
                    <option value="right" <?php echo ($currentPosition == 'right')? 'selected':''; ?> >RIGHT</option>
                </select>
            </label>
        </p>
        <button type="submit">
            Save
        </button>
    </form>
</div>