<?= $this->extend('Layouts/base') ?>
<?= $this->section('content') ?>
    <!-- Navbar Component -->
    <?= $this->include('Layouts/navbar') ?>

    <main class="container py-5">
        <div class="row mb-5 text-center">
            <div class="col-12">
                <h1 class="fw-bold mb-3 font-spartan">Términos y Condiciones de Uso</h1>
                <p class="lead text-muted">Lee detenidamente nuestras políticas legales antes de operar en el sitio.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Tarjeta Principal con Pestañas -->
                <div class="card rounded-4 border-0" style="box-shadow: 0px 10px 7px rgba(0, 0, 0, 0.26);">
                    <div class="card-header bg-white pt-4 pb-0 px-4 rounded-top-4 border-bottom-0">
                        <ul class="nav nav-tabs card-header-tabs flex-nowrap overflow-auto font-spartan" id="terminosTabs" role="tablist" style="white-space: nowrap; border-bottom: 2px solid #dee2e6;">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active fw-bold text-dark border-0 border-bottom border-dark border-3" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true" style="background: transparent;">1. Generales</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-muted border-0" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false" style="background: transparent;">2. Privacidad</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-muted border-0" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3" aria-selected="false" style="background: transparent;">3. Registro</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-muted border-0" id="tab4-tab" data-bs-toggle="tab" data-bs-target="#tab4" type="button" role="tab" aria-controls="tab4" aria-selected="false" style="background: transparent;">4. Productos</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-muted border-0" id="tab5-tab" data-bs-toggle="tab" data-bs-target="#tab5" type="button" role="tab" aria-controls="tab5" aria-selected="false" style="background: transparent;">5. Pagos</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-muted border-0" id="tab6-tab" data-bs-toggle="tab" data-bs-target="#tab6" type="button" role="tab" aria-controls="tab6" aria-selected="false" style="background: transparent;">6. Envíos</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-muted border-0" id="tab7-tab" data-bs-toggle="tab" data-bs-target="#tab7" type="button" role="tab" aria-controls="tab7" aria-selected="false" style="background: transparent;">7. Devoluciones</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-muted border-0" id="tab8-tab" data-bs-toggle="tab" data-bs-target="#tab8" type="button" role="tab" aria-controls="tab8" aria-selected="false" style="background: transparent;">8. Modificaciones</button>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body p-5">
                        <div class="tab-content" id="terminosTabsContent">
                            
                            <!-- Tab 1 -->
                            <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                                <h4 class="card-title font-spartan fw-bold mb-3">1. Condiciones Generales</h4>
                                <p class="card-text text-muted">
                                    El presente documento establece las Condiciones Generales de Uso del sitio web de Estética BV. El acceso, navegación y utilización de este sitio implican la aceptación plena y sin reservas de todas las disposiciones contenidas en estos Términos y Condiciones.
                                    El usuario se compromete a hacer un uso adecuado del sitio, respetando la normativa vigente y evitando cualquier actividad que pueda afectar la seguridad, integridad o funcionamiento del mismo. Asimismo, Estética BV se reserva el derecho de modificar en cualquier momento las presentes condiciones, las cuales serán publicadas y tendrán efecto inmediato desde su difusión en esta página.
                                </p>
                            </div>

                            <!-- Tab 2 -->
                            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                                <h4 class="card-title font-spartan fw-bold mb-3">2. Políticas de Privacidad</h4>
                                <p class="card-text text-muted">
                                    Estética BV garantiza la protección y confidencialidad de los datos personales proporcionados por los usuarios, en cumplimiento de la Ley de Protección de Datos Personales vigente en Argentina. La información recopilada será utilizada exclusivamente para fines relacionados con la prestación de servicios y la comunicación con los clientes.
                                    Los datos no serán cedidos, vendidos ni compartidos con terceros bajo ninguna circunstancia sin autorización previa y expresa del titular. Estética BV adopta las medidas técnicas y organizativas necesarias para asegurar la integridad y seguridad de la información, evitando su alteración, pérdida, tratamiento o acceso no autorizado.
                                    El usuario podrá ejercer en cualquier momento sus derechos de acceso, rectificación, actualización y supresión de sus datos personales, comunicándose directamente con Estética BV a través de los canales oficiales de contacto.
                                </p>
                            </div>

                            <!-- Tab 3 -->
                            <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                                <h4 class="card-title font-spartan fw-bold mb-3">3. Registro y Cuentas</h4>
                                <p class="card-text text-muted">
                                    Para acceder a determinados servicios y realizar compras en el sitio web de Estética BV, es obligatorio completar el formulario de registro en todos sus campos de manera veraz y precisa. El usuario se compromete a mantener actualizada la información proporcionada, garantizando su exactitud en todo momento.
                                    La contraseña asignada durante el proceso de registro es personal, única e intransferible, siendo responsabilidad exclusiva del usuario su custodia y uso. Estética BV no se responsabiliza por el uso indebido de las credenciales de acceso derivado de una gestión negligente por parte del titular.
                                </p>
                            </div>

                            <!-- Tab 4 -->
                            <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                                <h4 class="card-title font-spartan fw-bold mb-3">4. Catálogo y Productos</h4>
                                <p class="card-text text-muted">
                                    Estética BV se reserva el derecho de modificar, actualizar o discontinuar cualquier producto o servicio ofrecido en el sitio web sin previo aviso. Las imágenes, descripciones y precios de los productos son meramente ilustrativos y pueden variar según disponibilidad y condiciones del mercado.
                                    La información proporcionada sobre los productos tiene carácter informativo y no constituye una oferta vinculante. Estética BV se compromete a garantizar la calidad y autenticidad de los productos comercializados, cumpliendo con las normativas vigentes en materia de seguridad y etiquetado.
                                </p>
                            </div>

                            <!-- Tab 5 -->
                            <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab5-tab">
                                <h4 class="card-title font-spartan fw-bold mb-3">5. Medios de Pago y Facturación</h4>
                                <p class="card-text text-muted">
                                    Estética BV ofrece diversos medios de pago seguros y confiables para la adquisición de productos y servicios. Todos los pagos realizados a través del sitio web se procesan mediante plataformas de pago autorizadas, garantizando la protección de los datos financieros del usuario.
                                    La facturación se realizará conforme a la normativa fiscal vigente, emitiéndose comprobantes legales que respalden cada transacción. El usuario es responsable de verificar la exactitud de los datos ingresados durante el proceso de compra, así como de conservar los comprobantes emitidos para cualquier gestión futura.
                                </p>
                            </div>

                            <!-- Tab 6 -->
                            <div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="tab6-tab">
                                <h4 class="card-title font-spartan fw-bold mb-3">6. Envíos y Entregas</h4>
                                <p class="card-text text-muted">
                                    Estética BV se reserva el derecho de modificar, actualizar o discontinuar cualquier servicio de envío ofrecido en el sitio web sin previo aviso. Los plazos de entrega comienzan a correr a partir de la acreditación del pago. Los envíos se realizan mediante correos tercerizados, rigiéndose por los términos y tiempos de entrega de la empresa responsable.
                                </p>
                            </div>

                            <!-- Tab 7 -->
                            <div class="tab-pane fade" id="tab7" role="tabpanel" aria-labelledby="tab7-tab">
                                <h4 class="card-title font-spartan fw-bold mb-3">7. Cambios y Devoluciones</h4>
                                <p class="card-text text-muted">
                                    El usuario cuenta con un plazo de 10 días corridos desde la recepción del producto para solicitar su devolución, conforme a la normativa vigente en materia de defensa del consumidor.
                                    Para que la devolución sea aceptada, el producto deberá encontrarse sin uso, en perfectas condiciones, y conservar tanto sus etiquetas originales como su embalaje completo. No se admitirán devoluciones de artículos que presenten signos de uso, deterioro o manipulación indebida.
                                    Estética BV se reserva el derecho de verificar el estado del producto antes de proceder con la devolución y, en caso de cumplimiento de las condiciones establecidas, realizará el reintegro correspondiente por el mismo medio de pago utilizado en la compra.
                                </p>
                            </div>

                            <!-- Tab 8 -->
                            <div class="tab-pane fade" id="tab8" role="tabpanel" aria-labelledby="tab8-tab">
                                <h4 class="card-title font-spartan fw-bold mb-3">8. Modificaciones de Términos</h4>
                                <p class="card-text text-muted">
                                    Estética BV se reserva el derecho de modificar unilateralmente estos Términos y Condiciones en cualquier momento. Las modificaciones entrarán en vigencia a partir del momento en que sean publicadas en el sitio web.
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </main>

    <!-- Footer Component -->
    <?= $this->include('Layouts/footer') ?>

    <!-- Script para cambiar las clases activas en las pestañas visualmente (opcional para un diseño más limpio) -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tabElements = document.querySelectorAll('button[data-bs-toggle="tab"]');
            tabElements.forEach(function(tab) {
                tab.addEventListener('shown.bs.tab', function (event) {
                    // Remover estilos de todos
                    tabElements.forEach(t => {
                        t.classList.remove('fw-bold', 'text-dark', 'border-bottom', 'border-dark', 'border-3');
                        t.classList.add('text-muted');
                    });
                    // Agregar estilos al activo
                    event.target.classList.remove('text-muted');
                    event.target.classList.add('fw-bold', 'text-dark', 'border-bottom', 'border-dark', 'border-3');
                });
            });
        });
    </script>
<?= $this->endSection() ?>
