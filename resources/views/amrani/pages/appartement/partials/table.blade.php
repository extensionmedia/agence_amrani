<div class="overflow-x-auto">
    <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden bg-gray-100">
        <div class="w-full px-4 overflow-auto">
            <div class="flex items-center justify-between pt-6 gap-4">
                <div class="flex items-center gap-1 lg:gap-4">
                    <div class="rounded-lg border border-gray-300 overflow-hidden relative p-0">
                        <input id="req" type="text" class="input-form border-0 text-xs w-32 m-0 h-auto" placeholder="Chercher">
                        <button id="req_submit" class="absolute top-0 right-0 m-2 text-sm text-gray-400"><i class="fas fa-search"></i></button>
                    </div>
                    <select class="form-input w-32" id="appartement_service_id">
                        <option value="-1">-- Services</option>
                        @foreach ($services as $service)
                        <option value="{{$service->id}}">{{$service->appartement_service}}</option>
                        @endforeach
                    </select>
                    <select class="form-input w-32" id="appartement_situation">
                        <option value="-1">-- Situation</option>
                        @foreach ($situations as $situation)
                        <option value="{{$situation}}">{{$situation}}</option>
                        @endforeach
                    </select>
                    @include('amrani.pages.common.city', ['cities'=>$cities])
                </div>
                <a href="{{ route('appartement.create') }}" class="border px-4 py-2 rounded-lg bg-blue-400 hover:bg-gray-400 text-white text-sm">
                    <i class="far fa-plus"></i> 
                </a>
            </div>
            <div class="bg-white shadow-md rounded my-6 relative overflow-auto">
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left cursor-pointer">#CODE</th>
                            <th class="py-3 px-6 text-left cursor-pointer">Service</th>
                            <th class="py-3 px-6 text-left cursor-pointer">Situation</th>
                            <th class="py-3 px-6 text-left cursor-pointer">Ville</th>
                            <th class="py-3 px-6 text-center cursor-pointer">Etage</th>
                            <th class="py-3 px-6 text-center cursor-pointer">Surface</th>
                            <th class="py-3 px-6 text-center cursor-pointer">Nbr. Chambre</th>
                            <th class="py-3 px-6 text-right cursor-pointer">Prix</th>
                            <th class="py-3 px-2 text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($appartements as $appartement)
                            @include('amrani.pages.appartement.partials.tr', ['appartement'=>$appartement])
                        @endforeach
                    </tbody>
                </table>

                <div class="flex items-center gap-8 pb-4">
                    <div class="flex py-2 px-2 gap-1">
                        <button class="hover:bg-gray-400 active:bg-gray-500 py-2 px-5 bg-gray-300 rounded-md text-gray-600 border">
                            <i class="fas fa-angle-left"></i>
                        </button>
                        <button class="hover:bg-gray-400 active:bg-gray-500 py-2 px-5 bg-gray-300 rounded-md text-gray-600 border">
                            <i class="fas fa-angle-right"></i>
                        </button>
                    </div>
                    <div class="text-blue-400 text-xs total_items">Total Items</div>
                </div>

                <div class="absolute hidden loader_ top-0 left-0 right-0 bottom-0 bg-gray-600 bg-opacity-30">
                    <div class="w-24 mt-24 mx-auto text-center text-2xl">
                        <i class="fas fa-sync fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>


    $(document).ready(function(){
        $('.destroy_appartement').on('click', function(e){
            e.preventDefault();
            var that = $(this);
            Swal.fire({
                title: 'Supprimer?',
                icon: 'warning',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: `Supprimer`,
                denyButtonText: `Annuler`,
            }).then((result) => {
                if (result.isConfirmed) {
                    that.closest( "form" ).submit();
                }
            }
            );
        });
    });


    $('#req').keyup(function(e){
        if(e.keyCode == 13){
            $('#req_submit').trigger('change');
        }
    });

    $('#req_submit').on('click', function(){

        let data = {
                    '_token'                :   $('meta[name="csrf-token"]').attr('content'),
                    };

        $('.loader_').toggleClass('hidden');
        if($('#req').val() != ""){
            data.req = $('#req').val();
        }
        if($('#appartement_service_id').val() != "-1"){
            data.appartement_service_id = $('#appartement_service_id').val();
        }
        if($('#appartement_situation').val() != "-1"){
            data.appartement_situation = $('#appartement_situation').val();
        }
        
        if($("#city_id").val() != "-1"){
            data.city_id = $("#city_id").val();
        }
        if($("#city_sector_id").val() != "-1"){
            data.city_sector_id = $("#city_sector_id").val();
        }

        $.ajax({
            url: "{{route('appartement.filter')}}",
            data: data,
            type: 'POST',
            success: function(data){
                console.log(data);
                $('table tbody').html(data.success);
                $('.total_items').html('Total items ' + data.total)
                $('.loader_').toggleClass('hidden');
            },
            error: function(e){
                $('.loader_').toggleClass('hidden');
                console.log(e)
            }
        });
    });
    
</script>