<div>
    <x-slot name="header">Purchase</x-slot>

    <x-forms.m-panel>

        <section class="grid grid-cols-2">

            <div class="mt-3 flex flex-col gap-5 ">

                <!-- Party Name --------------------------------------------------------------------------------------->

                <x-dropdown.wrapper label="Party Name" type="contactTyped">
                    <div class="relative ">
                        <x-dropdown.input label="Party Name" id="contact_name"
                                          wire:model.live="contact_name"
                                          wire:keydown.arrow-up="decrementContact"
                                          wire:keydown.arrow-down="incrementContact"
                                          wire:keydown.enter="enterContact"/>
                        @error('contact_id')
                        <span class="text-red-500">{{'The Party Name is Required.'}}</span>
                        @enderror
                        <x-dropdown.select>
                            @if($contactCollection)
                                @forelse ($contactCollection as $i => $contact)
                                    <x-dropdown.option highlight="{{$highlightContact === $i  }}"
                                                       wire:click.prevent="setContact('{{$contact->vname}}','{{$contact->id}}')">
                                        {{ $contact->vname }}
                                    </x-dropdown.option>
                                @empty
                                    <a href="{{route('contacts.upsert',['0'])}}" role="button"
                                       class="flex items-center justify-center bg-green-100 w-full h-8 text-green-600 font-bold hover:scale-105 text-center">
                                        Not found , Want to create new
                                    </a>
                                @endforelse
                            @endif
                        </x-dropdown.select>
                    </div>
                </x-dropdown.wrapper>

                <!-- Order No --------------------------------------------------------------------------------------------->
                @if(\Aaran\Aadmin\Src\SaleEntry::hasOrder())
                    <x-dropdown.wrapper label="Order NO" type="orderTyped">
                        <div class="relative ">
                            <x-dropdown.input label="Order NO" id="order_name"
                                              wire:model.live="order_name"
                                              wire:keydown.arrow-up="decrementOrder"
                                              wire:keydown.arrow-down="incrementOrder"
                                              wire:keydown.enter="enterOrder"/>
                            @error('order_id')
                            <span class="text-red-500">{{'The Order is Required.'}}</span>
                            @enderror
                            <x-dropdown.select>
                                @if($orderCollection)
                                    @forelse ($orderCollection as $i => $order)
                                        <x-dropdown.option highlight="{{$highlightOrder === $i  }}"
                                                           wire:click.prevent="setOrder('{{$order->vname}}','{{$order->id}}')">
                                            {{ $order->vname }}
                                        </x-dropdown.option>
                                    @empty
                                        @livewire('controls.model.order-model',[$order_name])
                                    @endforelse
                                @endif
                            </x-dropdown.select>
                        </div>
                    </x-dropdown.wrapper>
                @endif

                <x-input.floating wire:model="purchase_no" label="Purchase No"/>
            </div>

            <!-- Top Right Area-------------------------------------------------------------------------------------------->

            <div class="ml-5 mt-3 flex flex-col gap-5">

                <x-input.floating wire:model="entry_no" label="Entry No"/>
                <x-input.floating wire:model="purchase_date" label="Purchase Date" type="date"/>
                <x-input.model-select wire:model="sales_type" :label="'Sales Type'">
                    <option class="text-gray-400"> choose ..</option>
                    <option value="CGST-SGST">CGST-SGST</option>
                    <option value="IGST">IGST</option>
                </x-input.model-select>
            </div>
        </section>
        <x-forms.section-border/>


        <!-- Purchase Items  -------------------------------------------------------------------------------------------------->

        <section class="text-xl font-bold text-orange-400">
            Purchase Item
        </section>

        <section class="md:flex md:flex-row w-full gap-0.5">

            <!--Product Name ---------------------------------------------------------------------------------------------->
            <x-dropdown.wrapper label="Product Name" type="productTyped">
                <div class="relative ">
                    <x-dropdown.input label="Product Name" id="product_name"
                                      wire:model.live="product_name"
                                      wire:keydown.arrow-up="decrementProduct"
                                      wire:keydown.arrow-down="incrementProduct"
                                      wire:keydown.enter="enterProduct"/>
                    @error('product_id')
                    <span class="text-red-500">{{'The Product Name is Required.'}}</span>
                    @enderror
                    <x-dropdown.select>
                        @if($productCollection)
                            @forelse ($productCollection as $i => $product)
                                <x-dropdown.option highlight="{{$highlightProduct === $i  }}"
                                                   wire:click.prevent="setProduct('{{$product->vname}}','{{$product->id}}','{{$product->gstpercent_id}}')">
                                    {{ $product->vname }} &nbsp;-&nbsp; GST&nbsp;:
                                    &nbsp;{{\Aaran\Entries\Models\Sale::commons($product->gstpercent_id)}}
                                    %
                                </x-dropdown.option>
                            @empty
                                @livewire('controls.model.product-model',[$product_name])
                            @endforelse
                        @endif
                    </x-dropdown.select>
                </div>
            </x-dropdown.wrapper>

            <!--Product Description --------------------------------------------------------------------------------------->

            @if(\Aaran\Aadmin\Src\SaleEntry::hasProductDescription())
                <x-input.floating wire:model.live="description" label="Description"/>
            @endif

            <!--Colour Name ----------------------------------------------------------------------------------------------->
            @if(\Aaran\Aadmin\Src\SaleEntry::hasColour())
                <x-dropdown.wrapper label="Color Name" type="colourTyped">
                    <div class="relative ">
                        <x-dropdown.input label="Color Name" id="colour_name"
                                          wire:model.live="colour_name"
                                          wire:keydown.arrow-up="decrementColour"
                                          wire:keydown.arrow-down="incrementColour"
                                          wire:keydown.enter="enterColour"/>
                        @error('color_id')
                        <span class="text-red-500">{{'The Color Name is Required.'}}</span>
                        @enderror
                        <x-dropdown.select>
                            @if($colourCollection)
                                @forelse ($colourCollection as $i => $colour)
                                    <x-dropdown.option highlight="{{$highlightColour === $i  }}"
                                                       wire:click.prevent="setColour('{{$colour->vname}}','{{$colour->id}}')">
                                        {{ $colour->vname }}
                                    </x-dropdown.option>
                                @empty
                                    <button wire:click.prevent="colourSave('{{$colour_name}}')"
                                            class="text-white bg-green-500 text-center w-full">
                                        create
                                    </button>
                                @endforelse
                            @endif
                        </x-dropdown.select>
                    </div>
                </x-dropdown.wrapper>
            @endif

            <!--Size ------------------------------------------------------------------------------------------------------>
            @if(\Aaran\Aadmin\Src\SaleEntry::hasSize())
                <x-dropdown.wrapper label="Size Name" type="sizeTyped">
                    <div class="relative ">
                        <x-dropdown.input label="Size Name" id="size_name"
                                          wire:model.live="size_name"
                                          wire:keydown.arrow-up="decrementSize"
                                          wire:keydown.arrow-down="incrementSize"
                                          wire:keydown.enter="enterSize"/>
                        @error('size_id')
                        <span class="text-red-500">{{'The Size name is Required.'}}</span>
                        @enderror
                        <x-dropdown.select>
                            @if($sizeCollection)
                                @forelse ($sizeCollection as $i => $size)
                                    <x-dropdown.option highlight="{{$highlightSize === $i  }}"
                                           wire:click.prevent="setSize('{{$size->vname}}','{{$size->id}}')">
                                        {{ $size->vname }}
                                    </x-dropdown.option>
                                @empty
                                    <button wire:click.prevent="sizeSave('{{$size_name}}')"
                                            class="text-white bg-green-500 text-center w-full">
                                        create
                                    </button>
                                @endforelse
                            @endif
                        </x-dropdown.select>
                    </div>
                </x-dropdown.wrapper>
            @endif

            <!-- Quantity ------------------------------------------------------------------------------------------------->

            <x-input.floating wire:model.live="qty" label="Quantity" autocomplete="false"/>
            <x-input.floating wire:model.live="price" label="Price" autocomplete="false"/>
            <button wire:click="addItems"
                    class="px-3 justify-items-center py-1 md:px-3 bg-green-500 text-white font-semibold tracking-wider hover:bg-green-600 transition-colors duration-300 ease-out">
                Add
            </button>
        </section>

        <!-- Display Items ----------------------------------------------------------------------------------------------->
        <section>
            <div class="py-2 mt-5 overflow-x-auto">

                <table class="overflow-x-auto md:w-full ">
                    <thead>
                    <tr class="h-8 text-xs bg-gray-100 border border-gray-300">

                        <th class="w-12 px-2 text-center border border-gray-300">#</th>

                        @if(\Aaran\Aadmin\Src\SaleEntry::hasPo_no())
                            <th class="px-2 text-center border border-gray-300">Po</th>
                        @endif

                        @if(\Aaran\Aadmin\Src\SaleEntry::hasDc_no())
                            <th class="px-2 text-center border border-gray-300">Dc</th>
                        @endif

                        @if(\Aaran\Aadmin\Src\SaleEntry::hasNo_of_roll())
                            <th class="px-2 text-center border border-gray-300">No of Roll</th>
                        @endif

                        <th class="px-2 text-center border border-gray-300">PRODUCT</th>

                        @if(\Aaran\Aadmin\Src\SaleEntry::hasColour())
                            <th class="px-2 text-center border border-gray-300">COLOUR</th>
                        @endif

                        @if(\Aaran\Aadmin\Src\SaleEntry::hasSize())
                            <th class="px-2 text-center border border-gray-300">SIZE</th>
                        @endif

                        <th class="px-2 text-center border border-gray-300">QTY</th>
                        <th class="px-2 text-center border border-gray-300">PRICE</th>
                        <th class="px-2 text-center border border-gray-300">TAXABLE</th>
                        <th class="px-2 text-center border border-gray-300">GST PERCENT</th>
                        <th class="px-2 text-center border border-gray-300">GST</th>
                        <th class="px-2 text-center border border-gray-300">SUBTOTAL</th>
                        <th class="w-12 px-1 text-center border border-gray-300">ACTION</th>
                    </tr>
                    </thead>

                    <!--Display Table Items ------------------------------------------------------------------------------->
                    <tbody>

                    @if ($itemList)

                        @foreach($itemList as $index => $row)

                            <tr class="border border-gray-400 hover:bg-amber-50">
                                <td class="text-center border border-gray-300 bg-gray-100">
                                    <button class="w-full h-full cursor-pointer"
                                            wire:click.prevent="changeItems({{$index}})">
                                        {{$index+1}}
                                    </button>
                                </td>

                                <td class="px-2 text-left border border-gray-300 cursor-pointer"
                                    wire:click.prevent="changeItems({{$index}})">
                                    <div>{{$row['product_name']}}
                                        @if($row['description'])
                                            &nbsp;-&nbsp;
                                        @endif
                                        @if(\Aaran\Aadmin\Src\SaleEntry::hasProductDescription())
                                            {{ $row['description']}}
                                        @endif
                                    </div>

                                </td>

                                @if(\Aaran\Aadmin\Src\SaleEntry::hasColour())
                                    <td class="px-2 text-left border border-gray-300 cursor-pointer"
                                        wire:click.prevent="changeItems({{$index}})">{{$row['colour_name']}}</td>
                                @endif

                                @if(\Aaran\Aadmin\Src\SaleEntry::hasSize())
                                    <td class="px-2 text-left border border-gray-300 cursor-pointer"
                                        wire:click.prevent="changeItems({{$index}})">{{$row['size_name']}}</td>
                                @endif

                                <td class="px-2 text-center border border-gray-300 cursor-pointer"
                                    wire:click.prevent="changeItems({{$index}})">{{$row['qty']}}</td>
                                <td class="px-2 text-right border border-gray-300 cursor-pointer"
                                    wire:click.prevent="changeItems({{$index}})">{{$row['price']}}</td>
                                <td class="px-2 text-right border border-gray-300 cursor-pointer"
                                    wire:click.prevent="changeItems({{$index}})">{{$row['taxable']}}</td>
                                <td class="px-2 text-center border border-gray-300 cursor-pointer"
                                    wire:click.prevent="changeItems({{$index}})">{{$row['gst_percent']}}</td>
                                <td class="px-2 text-right border border-gray-300 cursor-pointer"
                                    wire:click.prevent="changeItems({{$index}})">{{$row['gst_amount']}}</td>
                                <td class="px-2 text-right border border-gray-300 cursor-pointer"
                                    wire:click.prevent="changeItems({{$index}})">{{$row['subtotal']}}</td>
                                <td class="text-center border border-gray-300">
{{--                                    <button wire:click.prevent="removeItems({{$index}})"--}}
{{--                                            class="py-1.5 w-full text-red-500 items-center ">--}}
{{--                                        <x-icons.icon icon="trash" class="block w-auto h-6"/>--}}
{{--                                    </button>--}}

                                    <x-button.delete wire:click.prevent="removeItems({{$index}})" />
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>

                    <!-- Table Bottom ------------------------------------------------------------------------------------->
                    <tfoot class="mt-2">
                    <tr class="h-8 text-sm border border-gray-400 bg-cyan-50">

                        @if(\Aaran\Aadmin\Src\SaleEntry::hasSize() or \Aaran\Aadmin\Src\SaleEntry::hasColour())
                            <td colspan="4" class="px-2 text-xs text-right border border-gray-300">&nbsp;TOTALS&nbsp;&nbsp;&nbsp;</td>
                        @else
                            <td colspan="2" class="px-2 text-xs text-right border border-gray-300">&nbsp;TOTALS&nbsp;&nbsp;&nbsp;</td>
                        @endif

                        <td class="px-2 text-center border border-gray-300">{{$total_qty}}</td>
                        <td class="px-2 text-center border border-gray-300">&nbsp;</td>
                        <td class="px-2 text-right border border-gray-300">{{$total_taxable}}</td>
                        <td class="px-2 text-center border border-gray-300">&nbsp;</td>
                        <td class="px-2 text-right border border-gray-300">{{$total_gst}}</td>
                        <td class="px-2 text-right border border-gray-300">{{$grandtotalBeforeRound}}</td>
                        <td class="px-2 text-center border border-gray-300">&nbsp;</td>
                    </tr>
                    </tfoot>
                </table>

            </div>

        </section>
        <x-forms.section-border/>

        <section class="grid grid-cols-2 gap-2 ">
            <!-- Bottom Left -------------------------------------------------------------------------------------------------->
            <section class="w-full">
                <div class="w-3/4">
                    <x-accordion.accordion :heading="'Additional Charges'">
                        <x-input.floating wire:model="additional" wire:change.debounce="calculateTotal" label="Additional" />
                        <!-- Ledger ----------------------------------------------------------------------------------->
                        <x-dropdown.wrapper label="Ledger" type="ledgerTyped">
                            <div class="relative ">
                                <x-dropdown.input label="Ledger" id="ledger_name"
                                                  wire:model.live="ledger_name"
                                                  wire:keydown.arrow-up="decrementLedger"
                                                  wire:keydown.arrow-down="incrementLedger"
                                                  wire:keydown.enter="enterLedger"/>
                                @error('ledger_id')
                                <span class="text-red-500">{{'The Ledger is Required.'}}</span>
                                @enderror
                                <x-dropdown.select>
                                    @if($ledgerCollection)
                                        @forelse ($ledgerCollection as $i => $ledger)
                                            <x-dropdown.option highlight="{{$highlightLedger === $i  }}"
                                                               wire:click.prevent="setLedger('{{$ledger->vname}}','{{$ledger->id}}')">
                                                {{ $ledger->vname }}
                                            </x-dropdown.option>
                                        @empty
                                            <button
                                                wire:click.prevent="ledgerSave('{{$ledger_name}}')"
                                                class="text-white bg-green-500 text-center w-full">
                                                create
                                            </button>
                                        @endforelse
                                    @endif
                                </x-dropdown.select>
                            </div>
                        </x-dropdown.wrapper>

                    </x-accordion.accordion>
                    <!-- Transport ---------------------------------------------------------------------------------------->
                    <x-accordion.accordion :heading="'Others'">
                        <div class="mt-3 flex flex-col gap-2 ">
                            @if(\Aaran\Aadmin\Src\SaleEntry::hasTransport())
                                <x-dropdown.wrapper label="Transport" type="transportTyped">
                                    <div class="relative ">
                                        <x-dropdown.input label="Transport" id="transport_name"
                                                          wire:model.live="transport_name"
                                                          wire:keydown.arrow-up="decrementTransport"
                                                          wire:keydown.arrow-down="incrementTransport"
                                                          wire:keydown.enter="enterTransport"/>
                                        @error('transport_id')
                                        <span class="text-red-500">{{'The Transport is Required.'}}</span>
                                        @enderror
                                        <x-dropdown.select>
                                            @if($transportCollection)
                                                @forelse ($transportCollection as $i => $transport)
                                                    <x-dropdown.option highlight="{{$highlightTransport === $i  }}"
                                                                       wire:click.prevent="setTransport('{{$transport->vname}}','{{$transport->id}}')">
                                                        {{ $transport->vname }}
                                                    </x-dropdown.option>
                                                @empty
                                                    <button
                                                        wire:click.prevent="transportSave('{{$transport_name}}')"
                                                        class="text-white bg-green-500 text-center w-full">
                                                        create
                                                    </button>
                                                @endforelse
                                            @endif
                                        </x-dropdown.select>
                                    </div>
                                </x-dropdown.wrapper>
                            @endif

                            @if(\Aaran\Aadmin\Src\SaleEntry::hasDestination())
                                <x-input.floating  wire:model="destination" label="Destination"/>
                            @endif
                            @if(\Aaran\Aadmin\Src\SaleEntry::hasBundle())
                                <x-input.floating wire:model="bundle" label="Bundle" />
                            @endif
                        </div>
                    </x-accordion.accordion>
                </div>
            </section>

            <!-- Bottom Right  -------------------------------------------------------------------------------------------->

            <section class="w-full">
                <div class="w-3/4 mr-3 ml-auto ">

                    <div class="grid w-full md:grid-cols-2 pt-6">
                        <label
                            class="md:px-3 md:pb-2 text-left text-gray-600 text-md">Taxable&nbsp;Amount&nbsp;:&nbsp;&nbsp;</label>
                        <label
                            class="ml-8 md:px-3 md:pb-2 text-right text-gray-800 text-md">{{  $total_taxable }}</label>
                    </div>

                    <div class="grid w-full grid-cols-2 pt-6">
                        <label
                            class="px-3 pb-2 text-left text-gray-600 text-md">Gst&nbsp;:&nbsp;&nbsp;</label>
                        <label class="px-3 pb-2 text-right text-gray-800 text-md">{{  $total_gst }}</label>
                    </div>

                    <div class="grid w-full grid-cols-2 pt-6">
                        <label
                            class="px-3 pb-2 text-left text-gray-600 text-md">Round off&nbsp;:&nbsp;&nbsp;</label>
                        <label class="px-3 pb-2 text-right text-gray-800 text-md">{{$round_off}}</label>
                    </div>

                    <div class="grid w-full grid-cols-2 pt-6">
                        <label
                            class="mr-3 md:px-3 md:pb-2 text-xl text-left  text-gray-600">Grand&nbsp;Total&nbsp;:&nbsp;&nbsp;</label>
                        <label
                            class="ml-8  px-3 pb-2  md:px-3 md:pb-2 text-xl font-extrabold text-right text-gray-800">{{$grand_total}}</label>
                    </div>
                </div>
            </section>

        </section>
    </x-forms.m-panel>
    @if( $common->vid != "")
        <x-forms.m-panel-bottom-button save back print/>
    @else
        <x-forms.m-panel-bottom-button save back/>
    @endif
</div>
