<div class="overflow-x-auto">
    <div class="min-w-screen flex items-center justify-center font-sans overflow-hidden bg-gray-100">
        <div class="w-full lg:w-5/6 overflow-auto">
            <div class="flex items-center justify-between pt-6 gap-4">
                <div class="flex items-center gap-1 lg:gap-4">
                    <div class="rounded-lg border border-gray-300 overflow-hidden relative p-0">
                        <input type="text" class="input-form border-0 text-xs w-64 m-0 h-auto" placeholder="Chercher">
                        <button class="absolute top-0 right-0 m-2 text-sm text-gray-400"><i class="fas fa-search"></i></button>
                    </div>
                    <select class="form-input" id="service_serivce_id">
                        <option value="-1">Services</option>
                        @foreach ($services as $service)
                        <option value="{{$service->id}}">{{$service->terrain_service}}</option>
                        @endforeach
                    </select>
                    @include('amrani.pages.common.city', ['cities'=>$cities])
                </div>
                <a href="{{ route('terrain.create') }}" class="border px-4 py-2 rounded-lg bg-blue-400 hover:bg-gray-400 text-white text-sm">
                    <i class="far fa-plus"></i> 
                </a>
            </div>
            <div class="bg-white shadow-md rounded my-6">
                <table class="min-w-max w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left cursor-pointer">#CODE</th>
                            <th class="py-3 px-6 text-left cursor-pointer">Service</th>
                            <th class="py-3 px-6 text-left cursor-pointer">Situation</th>
                            <th class="py-3 px-6 text-left cursor-pointer">Ville</th>
                            <th class="py-3 px-6 text-center cursor-pointer">Surface</th>
                            <th class="py-3 px-6 text-right cursor-pointer">Prix</th>
                            <th class="py-3 px-2 text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($terrains as $terrain)
                            <tr class="border-b border-gray-200 bg-white hover:bg-gray-100">
                                <td class="py-1 px-6 text-left">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{$terrain->terrain_code}}</span>
                                    </div>
                                </td>
                                <td class="py-1 px-6 text-left">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{$terrain->service->terrain_service}}</span>
                                    </div>
                                </td>
                                <td class="py-1 px-6 text-left">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{$terrain->terrain_situation}}</span>
                                    </div>
                                </td>
                                <td class="py-1 px-6 text-left">
                                    <div class="flex items-center">
                                        <span class="font-medium">
                                            {{$terrain->city->city_name_fr }} @isset($terrain->city_sector) -> {{$terrain->city_sector->city_sector_name_fr}} @endisset 
                                       </span>
                                    </div>
                                </td>

                                <td class="py-1 px-6 text-center">
                                    <div class="font-bold">
                                        {{$terrain->surface}}
                                    </div>
                                </td>

                                <td class="py-1 px-6 text-right text-pink-700 font-bold">
                                    @money($terrain->prix_total) <span style="font-size: 8px" class="font-light">MAD</span>
                                </td>
                                <td class="py-1 text-right" style="width: 90px">
                                    <div class="flex justify-end pt-1">
                                        <div class="pt-1 w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                            @include('amrani.pages.terrain.partials.btn-edit')
                                        </div>
                                        <form class="pt-1 " action="{{route('terrain.destroy', $terrain->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="destroy_terrain w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                                @include('amrani.pages.terrain.partials.btn-delete')
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>


    $(document).ready(function(){
        $('.destroy_terrain').on('click', function(e){
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
    
    </script>