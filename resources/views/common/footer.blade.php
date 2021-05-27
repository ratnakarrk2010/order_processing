<!-- Opens from the button in the header -->
<div id="apps-modal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-sm modal-dialog modal-dialog-top">
                <div class="modal-content">
                    <!-- Apps card -->
                    <div class="card m-b-0">
                        <div class="card-header bg-app bg-inverse">
                            <h4>Apps</h4>
                            <ul class="card-actions">
                                <li>
                                    <button data-dismiss="modal" type="button"><i class="ion-close"></i></button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-block">
                            <div class="row text-center">
                                <div class="col-xs-6">
                                    <a class="card card-block m-b-0 bg-app-secondary bg-inverse" href="">
                                        <i class="ion-speedometer fa-4x"></i>
                                        <p>Admin</p>
                                    </a>
                                </div>
                                <div class="col-xs-6">
                                    <a class="card card-block m-b-0 bg-app-tertiary bg-inverse" href="">
                                        <i class="ion-laptop fa-4x"></i>
                                        <p>Frontend</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- .card-block -->
                    </div>
                    <!-- End Apps card -->
                </div>
            </div>
        </div>
        <!-- End Apps Modal -->

        <div class="app-ui-mask-modal"></div>

        
        <!-- Page Plugins -->
        <script src="{!! asset('theme/assets/js/plugins/slick/slick.min.js') !!}"></script>
        <script src="{!! asset('theme/assets/js/plugins/chartjs/Chart.min.js') !!}"></script>
        <script src="{!! asset('theme/assets/js/plugins/flot/jquery.flot.min.js') !!}"></script>
        <script src="{!! asset('theme/assets/js/plugins/flot/jquery.flot.pie.min.js') !!}"></script>
        <script src="{!! asset('theme/assets/js/plugins/flot/jquery.flot.stack.min.js') !!}"></script>
        <script src="{!! asset('theme/assets/js/plugins/flot/jquery.flot.resize.min.js') !!}"></script>
       

 
        <script>
            $(function()
            {
                // Init page helpers (Slick Slider plugin)
                App.initHelpers('slick');
            });
        </script>

    </body>

</html>