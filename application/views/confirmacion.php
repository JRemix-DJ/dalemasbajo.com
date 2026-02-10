 <div id="ajaxArea"> 
    <div class="pageArea">
    	<section>
    		<header class="style4 confirmacion">
		    	<div class="container">
		    		<div class="row">
		    			<div class="col-xs-12">
					    	<? if($confirm){ ?>
					    		<h2><? echo $message; ?></h2>
					    		<p>Haz click en login para seguir usando nuestra plataforma</p>
					    	<? }else{ ?>
					    		<h2><? echo $message; ?></h2>
					    		<p>Revisa tu cuenta, debes seguir el enlace que recibiste para que podamos confirmar tu cuenta.</p>
					    	<? } ?>
		    			</div>
		    		</div>
		    	</div> 
    		</header>
    	</section>
    </div>
</div>