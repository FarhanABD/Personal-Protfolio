<section class="contact-area section-padding" id="contact-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 text-center">
                <div class="section-title">
                    <h3 class="title">{{$contactTitle->title}}</h3>
                    <div class="desc">
                        <p>{{$contactTitle->sub_title}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" style="text-align: center;">
                <!-- Button WhatsApp -->
                <div class="form-box">
                    <a href="https://wa.me/6281353401336" target="_blank">
                        <button class="button-primary mouse-dir" type="button" id="whatsapp_btn">
                            Hubungi via WhatsApp
                            <span class="dir-part"></span>
                        </button>
                    </a>
                </div>
                <!-- Button WhatsApp / -->
            </div>            
        </div>
    </div>
</section>


@push('scripts')
<script>
    $(document).ready(function(){
        // Csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('submit', '#contact-form', function(e){
            e.preventDefault();
            $.ajax({
                    type: "POST",
                    url: "{{route('contact')}}",
                    data: $(this).serialize(),
                    beforeSend: function(){
                        $('#submit_btn').prop("disabled", true);
                        $('#submit_btn').text('Loading...');
                    },
                    success: function(response){
                        console.log(response);
                        if(response.status == 'success'){
                            toastr.success(response.message);
                            $('#submit_btn').prop("disabled", false);
                            $('#submit_btn').text('Send Now');
                            $('#contact-form').trigger('reset');
                        }
                    },
                    error: function(response){
                       if(response.status == 422){
                        let errorsMessage = $.parseJSON(response.responseText);

                        $.each(errorsMessage.errors, function(key, val){
                            console.log(val[0]);
                            toastr.error(val[0])
                        })
                        $('#submit_btn').prop("disabled", false);
                        $('#submit_btn').text('Send Now');

                       }
                    }
            })
        })
    })

</script>
@endpush
