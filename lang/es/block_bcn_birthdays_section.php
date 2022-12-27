<?php
$string['pluginname'] = 'BCN Cumpleaños Sección';
$string['bcn_birthdays_section'] = 'BCN Cumpleaños Sección';
$string['bcn_birthdays_section:addinstance'] = 'Agregar un nuevo bloque Bcn Sección Cumpleaños';
$string['bcn_birthdays_section:myaddinstance'] = 'Agregar un nuevo bloque Bcn Sección Cumpleaños a Mi pagina de moodle';
$string['text_square'] = 'Texto en cuadrado';
$string['identificador'] = 'Identificador';
$string['identificador_desc'] = 'Identificador del bloque';
$string['blockheight'] = 'Alto del bloque';

//Ajustes de titulo
$string['title_enabled'] = 'Mostrar titulo';
$string['title_text_color'] = 'Color del texto del titulo';
$string['title'] = 'Titulo';
$string['subtitle_enabled'] = 'Mostrar subtitulo';
$string['subtitle_text_color'] = 'Color del texto del subtitulo';
$string['subtitle'] = 'Subtitulo';
$string['title_hposition'] = 'Posicion horizontal del titulo';
$string['subtitle_hposition'] = 'Posicion horizontal del subititulo';

//Ajustes de contenido
$string['customization_enabled'] = 'Habilitar personalización de contenido.';
$string['columns_columns_stylesheet'] = 'Hoja de estilos para las columnas';


$string['content_column_1'] = 'Contenido de la primera columna';
$string['content_column_1_text_color'] = 'Color del texto del contenido de la primera columna';
$string['icon_1_color'] = 'Color del icono de la primera columna.';

$string['content_column_2'] = 'Contenido de la segunda columna';
$string['content_column_2_text_color'] = 'Color del texto del contenido de la segunda columna';
$string['icon_1_color'] = 'Color del icono de la segunda columna.';

//Estilos
//Estilos
$string['code_title'] = '<div class="bcn-title">
                            <h1>Cumpleaños</h1>
                        </div>
                        <div class="color-block"></div>
                        <br>';
$string['code_title_next_bd'] = '<div class="bcn-nextbd-title">
                        <h3>Próximos Cumpleaños</h3>
                    </div> <br>';

$string['code_stylesheet'] = '.tutorial-section-container {
                                    display: flex;
                                    }
                                    .tutorial-section-image-container {
                                    margin-right: 10px; 
                                    width: auto;
                                    }

                                    .tutorial-section-text-container {
                                    width: 50%;
                                    }

                                    @media only screen and (max-width: 768px) {
                                    .tutorial-section-container {
                                        flex-direction: row;
                                        align-items: center;
                                        gap: 2rem;
                                        }

                                    .tutorial-section-image-container {
                                        margin-right: 0; 
                                        width: auto;
                                    }

                                    .tutorial-section-text-container {
                                        width: auto;
                                        text-align: center;
                                    }
                                }

                                .tutorial-section-title h1{ 
                                    font-size: 1.75rem; 
                                    color: {{site-text-secondary-color}}; 
                                    margin-bottom: 0px; 
                                    font-weight: 700;
                                }

                                .tutorial-section-text-content{
                                    margin-top: 0;
                                    margin-bottom: 1rem;
                                    font-size: 1.5rem;
                                }

                                .video_icon_color{
                                    fill: {{content_column_2_text_color}};
                                }
                                
                                .pdf_icon_color{
                                    fill: {{content_column_2_text_color}};
                                }
                                
                                .video_icon_color{
                                    fill: {{icon_1_color}};
                                }
                                
                                .pdf_icon_color{
                                    fill: {{icon_2_color}};
                                }

                                .video-2 {
                                    letter-spacing: -.05em;
                                }

                                .video-3 {
                                    letter-spacing: -.01em;
                                }

                                .video-4 {
                                    fill: #fff;
                                    font-size: 20.64px;
                                }

                                .pdf-2 {
                                    letter-spacing: 0em;
                                  }
                            
                                .pdf-3 {
                                    letter-spacing: -.05em;
                                }
                            
                                .pdf-4 {
                                    letter-spacing: -.01em;
                                }
                            
                                .pdf-5 {
                                    fill: #fff;
                                    font-size: 20.64px;
                                }';


$string['code_column_1'] = '<div class="tutorial-section-container">
                                <div class="tutorial-section-image-container">
                                        <svg id="Capa 2" data-name="Capa 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 177.75 226.69" width="179" height="231">
                                        <defs>
                                        <style>
                                        .video-2 {
                                            letter-spacing: -.05em;
                                        }

                                        .video-3 {
                                            letter-spacing: -.01em;
                                        }

                                        .video-4 {
                                            fill: #fff;
                                            font-size: 20.64px;
                                        }
                                        </style>
                                        </defs>
                                        <g id="Capa_1-2" data-name="Capa 1">
                                            <g>
                                            <path d="M.19,214.69c0,6.6,5.4,12,12,12H165.56c6.6,0,12-5.4,12-12v-32.48H.19v32.48Z"/>
                                            <path d="M155.41,0H22.34C10,0,0,10,0,22.34V177.75H177.75V22.34c0-12.34-10-22.34-22.34-22.34ZM61.9,80.22c0-2.78,2.26-5.04,5.04-5.04s5.04,2.26,5.04,5.04v30.31l42.04-29.07-42.04-29.07v7.05c0,2.78-2.26,5.04-5.04,5.04s-5.04-2.26-5.04-5.04v-16.67c0-1.88,1.03-3.59,2.7-4.47,1.67-.87,3.66-.75,5.21,.32l55.95,38.69c1.36,.94,2.17,2.49,2.17,4.15s-.81,3.21-2.17,4.15l-55.95,38.69c-.85,.59-1.84,.9-2.87,.9-.81,0-1.62-.2-2.34-.58-1.67-.88-2.7-2.59-2.7-4.47v-39.93Zm92.07,75.68H46.87v3.39c0,2.94-2.4,5.34-5.34,5.34h0c-2.94,0-5.34-2.4-5.34-5.34v-3.39h-15.22c-2.21,0-4.01-1.79-4.01-4.01s1.79-4.01,4.01-4.01h15.22v-4.79c0-2.94,2.4-5.34,5.34-5.34h0c2.94,0,5.34,2.4,5.34,5.34v4.79h107.1c2.21,0,4.01,1.79,4.01,4.01s-1.79,4.01-4.01,4.01Z"/>
                                            </g>
                                            <text class="cls-4" transform="translate(24.08 206.6)"><tspan class="cls-3" x="0" y="0">V</tspan><tspan x="11.87" y="0">ER TU</tspan><tspan class="cls-2" x="66.23" y="0">T</tspan><tspan x="76.98" y="0">ORIAL </tspan></text>
                                        </g>
                                        </svg>
                                    </div>

                                <div class="tutorial-section-text-container">
                                    <div class="tutorial-section-title">
                                        <h1>CONOCE LA
                                            PLATAFORMA</h1>
                                    </div>
                                    <div class="tutorial-section-text-content">
                                        En nuestro video tutorial
                                        encontraras respuestas a
                                        las dudas que tengas sobre
                                        la navegación de nuestra
                                        plataforma educativa</div>
                                </div>
                                </div>';

$string['code_column_2'] = '<div class="tutorial-section-container">
                                <div class="tutorial-section-image-container">
                                    <svg id="Pdf" data-name="Capa 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 177.75 230.31" width="179" height="231">
                                    <defs>
                                      <style>
                                      .pdf-2 {
                                        letter-spacing: 0em;
                                      }
                                
                                      .pdf-3 {
                                        letter-spacing: -.05em;
                                      }
                                
                                      .pdf-4 {
                                        letter-spacing: -.01em;
                                      }
                                
                                      .pdf-5 {
                                        fill: #fff;
                                        font-size: 20.64px;
                                      }
                                      </style>
                                    </defs>
                                    <g id="Capa_1-2" data-name="Capa 1">
                                      <g>
                                        <path d="M83.91,78.64h7.28c1.92,0,3.48-.68,4.68-2.05,1.2-1.37,1.82-3.21,1.87-5.51v-14.84c0-2.31-.61-4.14-1.84-5.51-1.23-1.37-2.82-2.05-4.79-2.05h-7.21c-.34,0-.5,.17-.5,.5v28.97c0,.34,.17,.5,.5,.5Z"/>
                                        <path d="M40.6,60.77h7.28c1.97,0,3.57-.55,4.79-1.66,1.22-1.1,1.84-2.55,1.84-4.32s-.61-3.3-1.84-4.43c-1.22-1.13-2.82-1.69-4.79-1.69h-7.28c-.34,0-.5,.17-.5,.5v11.1c0,.34,.17,.5,.5,.5Z"/>
                                        <path d="M155.41,0H22.34C10,0,0,10,0,22.34V177.75H177.75V22.34c0-12.34-10-22.34-22.34-22.34Zm-39.44,39.73c0-.38,.12-.7,.36-.94,.24-.24,.55-.36,.94-.36h33.15c.38,0,.7,.12,.94,.36,.24,.24,.36,.55,.36,.94v7.64c0,.38-.12,.7-.36,.94s-.55,.36-.94,.36h-21.98c-.34,0-.5,.17-.5,.5v8.58c0,.34,.17,.5,.5,.5h13.91c.38,0,.7,.12,.94,.36,.24,.24,.36,.55,.36,.94v7.57c0,.38-.12,.7-.36,.94-.24,.24-.55,.36-.94,.36h-13.91c-.34,0-.5,.17-.5,.5v18.66c0,.38-.12,.7-.36,.94s-.55,.36-.94,.36h-9.37c-.39,0-.7-.12-.94-.36-.24-.24-.36-.55-.36-.94V39.73Zm-44.53,0c0-.38,.12-.7,.36-.94,.24-.24,.55-.36,.94-.36h17.94c3.75,0,7.06,.65,9.94,1.95,2.88,1.3,5.12,3.15,6.7,5.55,1.59,2.4,2.38,5.16,2.38,8.29v18.88c0,3.12-.79,5.88-2.38,8.29-1.58,2.4-3.82,4.25-6.7,5.55-2.88,1.3-6.2,1.95-9.94,1.95h-17.94c-.39,0-.7-.12-.94-.36-.24-.24-.36-.55-.36-.94V39.73Zm-43.3,0c0-.38,.12-.7,.36-.94,.24-.24,.55-.36,.94-.36h20.39c3.27,0,6.16,.67,8.68,2.02,2.52,1.35,4.47,3.23,5.84,5.66s2.05,5.22,2.05,8.39-.71,5.89-2.13,8.29c-1.42,2.4-3.42,4.25-6.02,5.55-2.59,1.3-5.6,1.95-9.01,1.95h-8.65c-.34,0-.5,.17-.5,.5v16.79c0,.38-.12,.7-.36,.94s-.55,.36-.94,.36h-9.37c-.38,0-.7-.12-.94-.36-.24-.24-.36-.55-.36-.94V39.73Zm131.25,116.12c0,2.21-1.79,4.01-4.01,4.01H22.37c-2.21,0-4.01-1.79-4.01-4.01h0c0-2.21,1.79-4.01,4.01-4.01H155.38c2.21,0,4.01,1.79,4.01,4.01h0Zm-4.01-17.26H22.37c-2.21,0-4.01-1.79-4.01-4.01s1.79-4.01,4.01-4.01H155.38c2.21,0,4.01,1.79,4.01,4.01s-1.79,4.01-4.01,4.01Zm0-21.63H22.37c-2.21,0-4.01-1.79-4.01-4.01s1.79-4.01,4.01-4.01H155.38c2.21,0,4.01,1.79,4.01,4.01s-1.79,4.01-4.01,4.01Z"/>
                                        <path d="M.19,218.31c0,6.6,5.4,12,12,12H165.56c6.6,0,12-5.4,12-12v-32.48H.19v32.48Z"/>
                                      </g>
                                      <text class="cls-5" transform="translate(24.08 210.21)"><tspan class="cls-4" x="0" y="0">V</tspan><tspan x="11.87" y="0">ER TU</tspan><tspan class="cls-3" x="66.23" y="0">T</tspan><tspan class="cls-2" x="76.98" y="0">ORIAL </tspan></text>
                                    </g>
                                  </svg>
                            </div>
                                <div class="tutorial-section-text-container">
                                    <div class="tutorial-section-title">
                                        <h1>MANUAL DEL
                                            ESTUDIANTE
                                        </h1>
                                    </div>
                                    <div class="tutorial-section-text-content">
                                        Toda la información
                                        necesaria para desarrollar
                                        nuestros cursos lo
                                        encuentras acá
                                    </div>
                                </div>
                                </div>';

$string['config_next_birtdays_height'] = 'Cantidad de dias visibles';
$string['header_config_text'] = 'Configuración Texto Superior';
$string['header_next_birtdays'] = 'Configuración de los Próximos Cumpleaños';
$string['header_todays_birtdays'] = 'Configuración de los Cumpleaños de Hoy';
$string['config_next_birtdays_height'] = 'Cantidad de dias visibles';
$string['config_next_birtdays_groupdate'] = 'Agrupación de usuarios por día';
$string['is_numeric'] = 'Debe ser un número';
$string['config_block_profile_field'] = 'Campo del usuario que almacena la Fecha de Nacimiento';
$string['config_block_profile_field_position'] = 'Campo del usuario que almacena el Cargo';
$string['bcn_birthdays_section_article'] = 'de';
$string['config_next_birtdays_bg_date'] = 'Color de fondo de cada Fecha';
$string['config_next_birtdays_date_text_color'] = 'Color del Texto de cada Fecha';
$string['config_next_birtdays_leftline_color'] = 'Color de la linea izquierda de la sección';
$string['config_block_bg_color'] = 'Color de fondo del Bloque';
$string['config_today_birtdays_carrusel'] = 'Formato de los Cumpleaños del Día';
$string['config_today_birtdays_date_bg_color'] = 'Color del Fondo de la Fecha';
$string['config_today_birtdays_date_color'] = 'Color del Texto de la Fecha';
$string['config_today_birtdays_name_color'] = 'Color del Texto del Nombre del Cumpleañero';
$string['backgroundimage'] = 'Background image';
$string['code_notconfigure'] = 'Campo de Cumpleaños no configurado todavía';
$string['code_nb_mensage'] = 'HOY NO TENEMOS CUMPLEAÑOS';
$string['code_today_mensage'] = 'NO HAY PRÓXIMOS CUMPLEAÑOS';
