<div id="back"></div>
<style>
  body {
    background-image: url("vistas/paginas/images/yate4.jpg");
    background-repeat: no-repeat;
    background-size: cover;
  }
</style>
<body>

  <div class="login-box">

    <div class="login-logo">

      <a><strong>YATES RESERVE</strong></a>
    
    </div>

    <div class="card">

      <div class="card-body login-card-body">

        <p class="login-box-msg"><strong>Acceso al Sistema</strong></p>

        <form method="post">

          <div class="input-group mb-3">

            <input type="text" class="form-control" placeholder="Ingresar Usuario" name="ingresoUsuario">

            <div class="input-group-append">

              <div class="input-group-text">

                <span class="fas fa-user"></span>

              </div>

            </div>

          </div>

          <div class="input-group mb-3">

            <input type="password" class="form-control" placeholder="Ingresar Contraseña" name="ingresoPassword">

            <div class="input-group-append">

              <div class="input-group-text">

                <span class="fas fa-lock"></span>

              </div>

            </div>

          </div>        

          <button type="submit" class="btn btn-primary btn-block btn-flat"   style="background-color: rgb(2, 150, 214);">INGRESAR</button>

           <?php

          $ingreso = new ControladorAdministradores();
          $ingreso -> ctrIngresoAdministradores(); 


          ?>     
   
        </form>

      </div>
 
    </div>

      </div>

</body>