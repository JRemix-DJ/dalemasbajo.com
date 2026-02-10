 <div id="ajaxArea"> 
    <!--========================================
    Page Content
    ===========================================-->
        <div class="pageArea">    
      
            <div>
                <div class="container">
                    <article class="articleSingle">
                        <div class="row">
                        	<div class="col-xs-12">
                                <div class="about-article text-center text-uppercase">
                                    <h2 class="text-semibold">CAMBIAR CONTRASEÑA</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        	<form id="changepass" action="#">
                        		<label>Password</label>
                        		<input type="password" name="password" id="cpassword">
                        		<label>Repetir Password</label>
                        		<input type="password" name="rpassword" id="crpassword">
                        		<input type="hidden" id="cuser_id" name="user_id" value="<? echo $user_id; ?>">
                        		
                            </form>
                        <button id="cambiarpass" class="btn btn-danger">Cambiar Password</button> 
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>