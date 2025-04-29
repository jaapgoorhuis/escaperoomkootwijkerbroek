<div>
    @if (Route::has('login'))
        <nav class="flex items-center justify-end gap-4">
            @auth
                <a
                    href="{{ url('/auth/dashboard') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                >
                    Dashboard
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                >
                    Log in
                </a>

                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                        Register
                    </a>
                @endif
            @endauth
        </nav>
    @endif

    @auth
        <div class="save-block-box">
            <button class="btn btn-secondary" onclick="saveBlocksToDatabase(this)"><i class='bx bx-save'></i></button>
        </div>
    @endauth
   <div class="container">
       @auth
       <div class="row">
           <div class="add-block-box col-12">
               <div class="add-block-box-header">
                   <i class='bx bx-plus add-block' onclick="showColumns()"></i>
               </div>
               <div class="add-block-box column-choise">
                   <div class="modal fade" id="add-column-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addColumn">
                       <div class="modal-dialog">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="add-column-modal">Kies een indeling</h5>
                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                               </div>
                               <div class="modal-body">
                                   <div class="row">
                                       <div id="column-1" class="col-6 column-choises" onclick="addColumn(this)">
                                           <div class="one-column"></div>
                                       </div>
                                       <div id="column-2" class="col-6 column-choises" onclick="addColumn(this)">
                                           <div class="two-column"></div>
                                           <div class="two-column"></div>
                                       </div>
                                       <div id="column-3" class="col-6 column-choises" onclick="addColumn(this)">
                                           <div class="three-column"></div>
                                           <div class="three-column"></div>
                                           <div class="three-column"></div>

                                       </div>
                                       <div id="column-4"class="col-6 column-choises" onclick="addColumn(this)">
                                           <div class="four-column"></div>
                                           <div class="four-column"></div>
                                           <div class="four-column"></div>
                                           <div class="four-column"></div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>


               </div>

               <div class="add-block-modal block-item-choise ">
                   <div class="modal fade" id="add-block-item-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addBlockItem" aria-hidden="true">
                       <div class="modal-dialog">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="addBlockItem">Voeg een blok toe</h5>
                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                               </div>
                               <div class="modal-body">
                                   <div class="row">
                                       <div class="col-6 block-item-type" onclick="setBlockItemType(this)" id="text-block-item">
                                           <label class="block-item-type-label">
                                               <input type="radio" name="blockItemType" value="text-block-item"/>
                                               <i class='bx bx-text'></i><br/>
                                               Tekst blok
                                           </label>
                                       </div>
                                       <div class="col-6 block-item-type" onclick="setBlockItemType(this)" id="image-block-item">
                                           <label class="block-item-type-label">
                                               <input type="radio" name="blockItemType" value="afbeelding-block-item"/>
                                               <i class='bx bx-image'></i><br/>
                                               Afbeelding blok
                                           </label>
                                       </div>
                                   </div>
                               </div>
                               <div class="error-message select-block-item hidden">
                                   Selecteer een blok
                               </div>

                               <div class="modal-footer">
                                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                                   <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="addBlockItemType()">Toevoegen</button>
                               </div>
                           </div>
                       </div>
                   </div>

                   <div class="modal fade" id="edit-column-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editColumn" aria-hidden="true">
                       <div class="modal-dialog modal-xl">
                           <div class="modal-content edit-column-modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="addBlockItem">Column bewerken</h5>
                                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                               </div>
                               <div class="modal-body">
                                   <div class="row">
                                       <div class="col-12">
                                           <div class="accordion" id="accordionExample">
                                               <div class="accordion-item">
                                                   <h2 class="accordion-header" id="headingOne">
                                                       <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                            Achtergrond
                                                       </button>
                                                   </h2>
                                                   <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                       <div class="accordion-body">
                                                           <div class="mb-3">
                                                               <label for="edit-column-color" class="form-label">Achtergrondkleur bewerken</label>
                                                               <input type="color" class="form-control form-control-color" id="edit-column-color" title="Kies een kleur">
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                               <div class="accordion-item">
                                                   <h2 class="accordion-header" id="headingTwo">
                                                       <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                           Margins
                                                       </button>
                                                   </h2>
                                                   <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                       <div class="accordion-body">
                                                            Word aan gewerkt.
                                                       </div>
                                                   </div>
                                               </div>

                                               <div class="accordion-item">
                                                   <h2 class="accordion-header" id="headingThree">
                                                       <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseTwo">
                                                           Aangepaste CSS
                                                       </button>
                                                   </h2>
                                                   <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                       <div class="accordion-body">
                                                           Word aan gewerkt.
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>


                               <div class="modal-footer">
                                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                                   <button type="button" class="btn btn-primary" id="saveEditedColumn">opslaan</button>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
       @endauth

       <div class="row home-row block-row" >
           @foreach(\App\Models\PageBlock::get() as $pageblocks)
               @if($pageblocks->page_id == $this->pageid)
                   {!! $pageblocks->value !!}
               @endif
           @endforeach

           @if(!$this->pageid)
               @foreach(\App\Models\PageBlock::where('page_id', $this->indexPage->id)->get() as $pageblocks)
                    {!! $pageblocks->value !!}
               @endforeach
           @endif

       </div>

   </div>
</div>
