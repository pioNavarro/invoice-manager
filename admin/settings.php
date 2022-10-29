<div class="wrap" >
    <div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible"> 
        <p><strong>Settings saved.</strong></p>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text">Dismiss this notice.</span>
        </button>
    </div>
    <h1>Invoice Settings</h1>
    <form action="" method="POST">
        <p>
            <label> Currency Code : 
                <input type="text" name="currency_code"/>
            </label>
        </p>
        <p>
            <label> Currency Position : 
                <select name="current_position">
                    <option value="left">LEFT</option>
                    <option value="right">RIGHT</option>
                </select>
            </label>
        </p>
        <button type="button">
            Save
        </button>
    </form>
</div>