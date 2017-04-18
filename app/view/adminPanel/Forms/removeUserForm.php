<?php

class removeUserForm {
    private $users;
    
    function __construct($users) {
        $this->users = $users;
    }
    
    public function show() {        
?>
<form class="form-horizontal" method="POST">
    <fieldset>
        <!-- Form Name -->
        <legend>Usuwanie użytkowników</legend>

        <!-- Select Multiple -->
        <div class="form-group">
            <label class="col-md-2 control-label" for="usersToRemove">Użytkownicy</label>
            <div class="col-md-9">
                <select id="usersToRemove" name="usersToRemove[]" class="form-control" multiple="multiple">
                    <?php 
                    foreach ($this->users as $user) {
                        $id = $user["user_id"];
                        $fullname = $user["fname"] . ' ' . $user["sname"];
                        echo '<option value="' . $id . '">' . $id . '. ' .$fullname . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- Button -->
        <div class="form-group">
            <label class="col-md-2 control-label" for="removeButton"></label>
            <div class="col-md-9">
                <button id="removeButton" class="btn btn-danger">Usuń</button>
            </div>
        </div>
    </fieldset>
</form>
<?php
    }
}
?>