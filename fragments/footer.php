    <footer class="footer mt-auto py-3">
         <div class="footer_top">
            <div class="container text-<?php if($dark) echo 'light'; else echo 'dark'; ?>">
                <div class="row">
                    <div class="col-lg-6">
                        <h5 style="text-align: center;">Aplicación</h5>

                        <div class="col-lg-12">
                            <button class="btn btn-link btn-block">Generador de llaves</button>
                        </div>
                        
                        <div class="col-lg-7 separator"></div>
                    </div>

                    <div class="col-lg-6">
                        <h5 style="text-align: center;">Desarrollo</h5>

                        <div class="col-lg-12">
                            <button class="btn btn-link btn-block">Tests</button>
                        </div>
                        <div class="col-lg-7 separator"></div>
                        <div class="col-lg-7 separator"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="copy-right_text">
            <div class="container">
                <div class="footer_border"></div>
                <div class="row">
                    <div class="col-xl-7">
                        <p class="copy_right">
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> 
                            Todos los derechos reservados</a>
                        </p>
                    </div>

                    <div class="col-xl-2">
                        <button class="btn btn-block" onclick="location.href='https://FelipeSpirit.github.io';"><img src="/images/FS-logo-lg-border-min.png" style="width: 100%;"></button>
                        <div class="col-lg-7 separator"></div>
                    </div>

                    <div class="col-xl-3">
                        <button onclick="toggleTheme(<?php if($dark) echo 'true'; ?>);" class="btn btn-block btn-<?php if($dark) echo "light"; else echo "dark"; ?>"><?php if($dark) echo "Light"; else echo "Dark"; ?></button>
                    </div>
                </div>
            </div>
        </div>
    </footer>