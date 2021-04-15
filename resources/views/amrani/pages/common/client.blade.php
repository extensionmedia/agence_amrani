<div class="w-full lg:w-4/6 mx-auto bg-white my-5 rounded border shadow-sm">
    <div class="flex items-center justify-between bg-gray-50">
        @include('components.ui.title', ['title'=>'Client / Intermediaire'])
        <div class="new_client btn p-2 mr-2 text-green-400 cursor-pointer hover:text-green-600"><i class="fas fa-user-plus"></i> Nouveau</div>
        <div class="abort_new_client hidden btn p-2 mr-2 text-red-400 cursor-pointer hover:text-red-600"><i class="fas fa-ban"></i> Annuler</div>
    </div>
    
    <hr>
    
    <div class="flex items-center block gap-4 mb-4 mt-4">
        <label class="w-1/5 text-right text-gray-500 text-sm" for=""></label>
        <div class="relative w-3/5">
            @if(isset($intermediaire))
               @include('components.ui.switch', ['title'=>'Intermediaire / وسيط', 'name'=>'is_intermediaire', 'checked'=>'checked']) 
            @else
               @include('components.ui.switch', ['title'=>'Intermediaire / وسيط', 'name'=>'is_intermediaire', 'checked'=>'']) 
            @endif
        </div>
    </div>


    <div class="flex items-center block gap-4 mb-4 ">
        <label class="w-1/5 text-right text-gray-500 text-sm" for="client_name">Nom Client</label>
        <div class="relative w-3/5">
            <input @isset($intermediaire) value="{{$intermediaire->intermediaire_name}}" @endisset @isset($client) value="{{$client->client_name}}" @endisset autocomplete="off" class="form-input w-full form-input-search" type="text" id="client_name" name="client_name" required>
            <span class="absolute top-0 right-0 p-2 mr-2 text-gray-400 cursor-pointer hover:text-gray-600"><i class="fas fa-search"></i></span>
            <div class="form-input-search-result hidden absolute top-0 left-0 z-10 bg-blue-50 border w-full max-h-48 py-2 px-2 mt-8 overflow-y-auto shadow-lg">
            </div>                            
        </div>

    </div>
    <input type="hidden" id="client_id" value="0" name="client_id">
    <input type="hidden" id="intermediaire_id" value="0" name="intermediaire_id">
    <div class="flex items-center block gap-4 mb-4">
        <label class="w-1/5 text-right text-gray-500 text-sm" for="client_category_id">Category</label>
        <select disabled class="bg-gray-200 form-input w-3/5" id="client_category_id" name="client_category_id">
            @isset($intermediaire)
                
            @endisset
        @foreach ($client_categories as $category)
            <option value="{{$category->id}}" @if ($category->is_default) data-default="1" selected @endif>{{$category->client_category}}</option>
        @endforeach
        </select>
    </div>

    <div class="flex items-center block gap-4 mb-4">
        <label class="w-1/5 text-right text-gray-500 text-sm" for="client_status_id">Status du client</label>
        <select disabled class="bg-gray-200 form-input w-3/5" id="client_status_id" name="client_status_id">
        @foreach ($client_statuses as $status)
            <option value="{{$status->id}}" @if ($status->is_default) data-default="1" selected @endif>{{$status->client_status}}</option>
        @endforeach
        </select>
    </div>

    <div class="flex items-center block gap-4 mb-4">
        <label class="w-1/5 text-right text-gray-500 text-sm" for="client_city">Ville</label>
        <input disabled class="bg-gray-200 form-input w-3/5" type="text" id="client_city" name="client_city">
    </div>

    <div class="flex items-center block gap-4 mb-4">
        <label class="w-1/5 text-right text-gray-500 text-sm" for="client_telephone">Téléphone</label>
        <input disabled class="bg-gray-200 form-input" type="text" id="client_telephone" name="client_telephone">
    </div>
</div>

<script>
    $(document).ready(function(){

        /** Search Client **/
        $('.form-input-search').on('keyup', function(){
            var input = $(this).val();
            if(input.length > 1){
                $('.form-input-search-result').removeClass('hidden').html(
                    '<div class="w-full my-4 text-center"><i class="fas fa-sync fa-spin"></i></div>'
                );
                
                $.ajax({
                    type		: 	"POST",
                    url: "{{route('client.search')}}",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        req: input,
                        is_intermediaire: $("#is_intermediaire").is(':checked')? 1:0,
                    },
                    dataType	: 	"json",
                }).done(function(response){
                    var ul = '<ul class="">'
                    for (item in response) {
                        if($("#is_intermediaire").is(':checked')){
                            ul += '<li data-city="'+response[item].intermediaire_city+'" data-telephone="'+response[item].intermediaire_telephone+'" data-status_id="'+response[item].status.id+'" data-category_id="'+response[item].category.id+'" data-id="'+response[item].id+'" class="select_this text-sm rounded-lg -mx-1 hover:bg-blue-100 cursor-pointer px-3 py-1">'+ response[item].intermediaire_name + '</li>';
                        }else{
                            ul += '<li data-city="'+response[item].client_city+'" data-telephone="'+response[item].client_telephone+'" data-status_id="'+response[item].status.id+'" data-category_id="'+response[item].category.id+'" data-id="'+response[item].id+'" class="select_this text-sm rounded-lg -mx-1 hover:bg-blue-100 cursor-pointer px-3 py-1">'+ response[item].client_name + '</li>';
                        }
                    } 
                    ul += '</ul>';
                    if(response.length){
                        $('.form-input-search-result').html(ul);
                    }else{
                        $('.form-input-search-result').addClass('hidden').html('');
                    }

                }).fail(function(xhr){
                    alert("Error");
                    console.log(xhr.responseText);
                });                
            }else{
                $('.form-input-search-result').addClass('hidden');
            }
        });

        $('#client_name').keydown(function (e) {
            if (e.keyCode == 13) {
               
                if($(this).val() == ""){

                    $('#client_category_id > option').each(function(){
                        if($(this).hasAttr('data-default')) {
                            $('#client_category_id').val($(this).val()).prop("disabled", true).addClass('bg-gray-200');
                        }
                    });

                    $('#client_status_id > option').each(function(){
                        if($(this).hasAttr('data-default')) {
                            $('#client_status_id').val($(this).val()).prop("disabled", true).addClass('bg-gray-200');
                        }
                    });
                    $('#client_telephone').val('').prop("disabled", true).addClass('bg-gray-200');
                    $('#client_city').val('').prop("disabled", true).addClass('bg-gray-200');
                    $("#client_id").val(0);
                    $("#intermediaire_id").val(0);
                }
                e.preventDefault();
            }
        });

        /** Delete search result after click out **/
        $(document).click(function(e) { 
            if (e.target.id !== 'client_name') {
                $('.form-input-search-result').addClass('hidden');
            }        
        });

        /** Choose a client and past it in form **/
        $(document).on('click', '.select_this', function(){
            $("#client_name").val($(this).html());
            $("#client_category_id").val($(this).data('category_id'));
            $("#client_status_id").val($(this).data('status_id'));
            $("#client_city").val($(this).data('city'));
            $("#client_telephone").val($(this).data('telephone'));
            if($("#is_intermediaire").is(':checked')) {
                $("#intermediaire_id").val( $(this).data('id') );
                $("#client_id").val( 0 )
            }else{
                $("#client_id").val( $(this).data('id') );
                $("#intermediaire_id").val( 0 )
            }
        });


        $.fn.hasAttr = function(name) {  
            return this.attr(name) !== undefined;
        };

        $('.abort_new_client').on('click', function(e){
            e.preventDefault();
            $(".new_client").removeClass('hidden');
            $(this).addClass('hidden');

            $('#client_name').val('');

            $('#client_category_id > option').each(function(){
                if($(this).hasAttr('data-default')) {
                    $('#client_category_id').val($(this).val()).prop("disabled", true).addClass('bg-gray-200');
                }
            });

            $('#client_status_id > option').each(function(){
                if($(this).hasAttr('data-default')) {
                    $('#client_status_id').val($(this).val()).prop("disabled", true).addClass('bg-gray-200');
                }
            });
            $('#client_telephone').val('').prop("disabled", true).addClass('bg-gray-200');
            $('#client_city').val('').prop("disabled", true).addClass('bg-gray-200');
            $("#client_id").val(0);
            $("#intermediaire_id").val(0);
            $("#client_name").focus();

        });

        $('.new_client').on('click', function(e){
            e.preventDefault();
            $(".abort_new_client").removeClass('hidden');
            $(this).addClass('hidden');

            $('#client_name').val('');

            $('#client_category_id > option').each(function(){
                if($(this).hasAttr('data-default')) {
                    $('#client_category_id').val($(this).val()).prop("disabled", false).removeClass('bg-gray-200');
                }
            });

            $('#client_status_id > option').each(function(){
                if($(this).hasAttr('data-default')) {
                    $('#client_status_id').val($(this).val()).prop("disabled", false).removeClass('bg-gray-200');
                }
            });
            $('#client_telephone').val('').prop("disabled", false).removeClass('bg-gray-200');
            $('#client_city').val('').prop("disabled", false).removeClass('bg-gray-200');
            $("#client_id").val(0);
            $("#intermediaire_id").val(0);
            $("#client_name").focus();

        });
    });
</script>