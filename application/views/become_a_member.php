    <div id="ajaxArea"> 
      <section class="album-header">
            <figure class="album-cover-wrap">
                <div class="album-cover_overlay"></div>
            </figure>
            <div class="container">
                <div class="cover-content">
                   <hr>
                    <div class="clearfix text-uppercase">
                        <h1 style="padding-top: 30px">CONVIERTETE EN UN EDITOR</h1>
                        <cite class="album-author mb-20">DALE MAS BAJO</cite>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container mt-30 mb-30">
                <div class="row">
                        <form action="">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" name="name" id="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="">País</label>
                                    <select name="country" class="form-control" id="country" required>
                                        <option value="">Seleccione una opción</option>
                                    <? foreach($paises as $pais){ ?>
                                        <option value="<? echo $pais->name; ?>"><? echo $pais->name; ?></option>
                                    <? } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Experiencia</label>
                                    <select name="time" class="form-control" id="time" required>
                                        <option value="">Seleccione una opción</option>
                                        <option value="1">MENOS DE UN AÑO</option>
                                        <option value="2">1 A 2 AÑOS</option>
                                        <option value="3">3 A 5 AÑOS</option>
                                        <option value="4">6 O MÁS AÑOS</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">¿Trabajas con otro servicio como este?</label>
                                    <select name="work" id="work" class="form-control" required>
                                        <option value="">Seleccione una opcion</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Trabajos Realizados</label>
                                    <input type="url" name="trabajos" id="trabajos" class="form-control" placeholder="Puede ser un enlace de soundcloud, google drive, etc." required>
                                    
                                </div>
                                <div class="form-group">
                                    <label for="">E-mail</label>
                                    <input type="text" id="email-become" name="email" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Cuentanos: ¿Porqué te gustaría ser parte de DALEMASBAJO.COM?</label>
                                    <textarea name="why" id="why" class="form-control" id="" cols="30" rows="10" required></textarea>
                                </div>
                                <a class="btn btn-danger" id="enviarBecome">Enviar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>