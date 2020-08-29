<?php
include "init.php";
?>
<br><br><br>
<div class="container text-center">
    <div class="row anm-row" >

        <div class="col">
            <form>
                <div class="form-group row">
                    <label for="anm-email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="anm-email" placeholder="Username">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="anm-Password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="anm-Password" placeholder="Password">
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-success btn-block">anmelden</button>
            </form>
        </div>

        <div class="col">
            <form>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" readonly class="form-control" id="staticEmail" placeholder="Username">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary btn-block">regesteiren</button>
            </form>
        </div>

    </div>
</div>