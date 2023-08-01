<x-filament::page>
{{--    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.css" rel="stylesheet" />--}}

    <style>
        .bg-purple-50 {
            --tw-bg-opacity: 1;
            /* background-color: rgb(250 245 255 / var(--tw-bg-opacity)); */
        }
        .bg-derk-600{
            background: black;
        }
        .bg-gray-600{
            background: #726f6f;
        }
    </style>
   @php
   $folder = \App\Models\Folder::find($this->folder_id);
   @endphp
    @if($folder->parent_folder_id)
        <div class="flex-1">
            <div>
                <div class="pl-6 pr-6 w-full max-w-5xl mx-auto">
                    <section class="m-20_ss">
                       <div class="grid ">
                           <h3 class="font-big">
                               <a class="flex items-center justify-center gap-3 px-3 py-2 rounded-lg font-medium transition bg-primary-500 text-white break-all"  href="{{route('dowloadRqCode',['url'=>env('BOT_URL')."?widget=".$embedded_id])}}" >CLICK HERE to download OR QRCODE image</a>
                           </h3>
                           <h3 class="font-big  mt-4">
                               <a class="flex items-center justify-center gap-3 px-3 py-2 rounded-lg font-medium transition bg-primary-500 text-white break-all" href="{{env('BOT_URL')."?widget=".$embedded_id}}" target="_blank">{{env('BOT_URL')."?widget=".$embedded_id}}</a>
                           </h3>

                           <h3 class="font-big  mt-4">
                              {{__('Please add this script to head tag <head></head>')}}
                           </h3>

                           <code class="flex mt-4 items-center justify-center gap-3 px-3 py-2 rounded-lg font-medium transition bg-primary-500 text-white break-all">
                               &lt;script src="{{asset('js/bot.js')}}" data-widget="{{$embedded_id}}"
                               @if($folder->script_expand_icon)
                                   data-expand="{{asset('storage/'.$folder->script_expand_icon)}}"
                               @else
                                   data-expand="{{asset('icons/expand-svgrepo-com.svg')}}"
                               @endif

                               @if($folder->script_collapsable_icon)
                                   data-collapse="{{asset('storage/'.$folder->script_collapsable_icon)}}"
                               @else
                                   data-collapse="{{asset('icons/collapse-svgrepo-com.svg')}}"
                               @endif

                               @if($folder->script_expand_icon)
                                   data-color="{{$folder->script_collapsable_background_color}}"
                               @else
                                   data-color="#970986"
                               @endif

                               &gt;&lt;/script&gt;


                           </code>


                         @if($folder->whatsapp_number && $folder->whatsapp_access_token && $folder->whatsapp_id)
                           <h3 class="font-big mt-2">
                               <a class="flex items-center justify-center gap-3 px-3 py-2 rounded-lg font-medium transition bg-primary-500 text-white break-all" href="https://wa.me/{{$folder->whatsapp_number}}" target="_blank">https://wa.me/{{$folder->whatsapp_number}}</a>
                           </h3>
                           @endif

                           <h3 class="font-medium mt-2">ADD TRAINING DOCUMENTS</h3>
                           <p class="text-slate-500 text-sm"> You can add new training documents in this folder by uploading an existing document </p>
                           {{--                    <button class="flex items-center gap-2 mb-2 hide">--}}
                           {{--                        <svg class="w-4 h-4" viewBox="0 0 320 512" xmlns="http://www.w3.org/2000/svg">--}}
                           {{--                            <path d="M7 239c-9.4 9.4-9.4 24.6 0 33.9L199 465c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L57.9 256 233 81c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0L7 239z" fill="currentColor"></path></svg>--}}
                           {{--                        <span>Options</span>--}}
                           {{--                    </button>--}}
                           <div class="mt-4 grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 upl">
                               <div class="mt-4 grid">
                                   <a  href="{{route('filament.resources.contents.create',['folder_id'=>$this->folder_id,'type'=>'txt'])}}" class="px-4 py-3 rounded-lg text-left border-2 border-purple-400 bg-purple-50 transition-colors hover:border-purple-500 hover:bg-purple-100 focus:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2">
                                       <svg aria-hidden="true" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-800"><path d="M122.6 155.1L240 51.63V368c0 8.844 7.156 16 16 16s16-7.156 16-16V51.63l117.4 104.3C392.4 158.7 396.2 160 400 160c4.406 0 8.812-1.812 11.97-5.375c5.875-6.594 5.25-16.72-1.344-22.58l-144-128c-6.062-5.406-15.19-5.406-21.25 0l-144 128C94.78 137.9 94.16 148 100 154.6S116.1 161.8 122.6 155.1zM448 320h-112c-8.836 0-16 7.162-16 16c0 8.836 7.164 16 16 16H448c17.67 0 32 14.33 32 32v64c0 17.67-14.33 32-32 32H64c-17.67 0-32-14.33-32-32v-64c0-17.67 14.33-32 32-32h112C184.8 352 192 344.8 192 336C192 327.2 184.8 320 176 320H64c-35.35 0-64 28.65-64 64v64c0 35.35 28.65 64 64 64h384c35.35 0 64-28.65 64-64v-64C512 348.7 483.3 320 448 320zM440 416c0-13.25-10.75-24-24-24s-24 10.75-24 24s10.75 24 24 24S440 429.3 440 416z" fill="currentColor"></path></svg>
                                       <div class="mt-2 font-medium text-lg">Write</div>
                                       <div class="leading-snug text-slate-800"> Write text here. </div>
                                   </a>
                               </div>
{{--                               <div class="mt-4 grid">--}}
{{--                                   <a  href="{{route('filament.resources.contents.create',['folder_id'=>$this->folder_id,'type'=>'file'])}}" class="px-4 py-3 rounded-lg text-left border-2 border-purple-400 bg-purple-50 transition-colors hover:border-purple-500 hover:bg-purple-100 focus:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2">--}}
{{--                                       <svg aria-hidden="true" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-800"><path d="M122.6 155.1L240 51.63V368c0 8.844 7.156 16 16 16s16-7.156 16-16V51.63l117.4 104.3C392.4 158.7 396.2 160 400 160c4.406 0 8.812-1.812 11.97-5.375c5.875-6.594 5.25-16.72-1.344-22.58l-144-128c-6.062-5.406-15.19-5.406-21.25 0l-144 128C94.78 137.9 94.16 148 100 154.6S116.1 161.8 122.6 155.1zM448 320h-112c-8.836 0-16 7.162-16 16c0 8.836 7.164 16 16 16H448c17.67 0 32 14.33 32 32v64c0 17.67-14.33 32-32 32H64c-17.67 0-32-14.33-32-32v-64c0-17.67 14.33-32 32-32h112C184.8 352 192 344.8 192 336C192 327.2 184.8 320 176 320H64c-35.35 0-64 28.65-64 64v64c0 35.35 28.65 64 64 64h384c35.35 0 64-28.65 64-64v-64C512 348.7 483.3 320 448 320zM440 416c0-13.25-10.75-24-24-24s-24 10.75-24 24s10.75 24 24 24S440 429.3 440 416z" fill="currentColor"></path></svg>--}}
{{--                                       <div class="mt-2 font-medium text-lg">Upload</div>--}}
{{--                                       <div class="leading-snug text-slate-800"> PDF, Word or Powerpoint files. </div>--}}
{{--                                   </a>--}}
{{--                               </div>--}}
                               <div class="mt-4 grid">
                                   <a  href="{{route('filament.resources.contents.create',['folder_id'=>$this->folder_id,'type'=>'url'])}}" class="px-4 py-3 rounded-lg text-left border-2 border-purple-400 bg-purple-50 transition-colors hover:border-purple-500 hover:bg-purple-100 focus:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2">
                                       <svg aria-hidden="true" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-800"><path d="M122.6 155.1L240 51.63V368c0 8.844 7.156 16 16 16s16-7.156 16-16V51.63l117.4 104.3C392.4 158.7 396.2 160 400 160c4.406 0 8.812-1.812 11.97-5.375c5.875-6.594 5.25-16.72-1.344-22.58l-144-128c-6.062-5.406-15.19-5.406-21.25 0l-144 128C94.78 137.9 94.16 148 100 154.6S116.1 161.8 122.6 155.1zM448 320h-112c-8.836 0-16 7.162-16 16c0 8.836 7.164 16 16 16H448c17.67 0 32 14.33 32 32v64c0 17.67-14.33 32-32 32H64c-17.67 0-32-14.33-32-32v-64c0-17.67 14.33-32 32-32h112C184.8 352 192 344.8 192 336C192 327.2 184.8 320 176 320H64c-35.35 0-64 28.65-64 64v64c0 35.35 28.65 64 64 64h384c35.35 0 64-28.65 64-64v-64C512 348.7 483.3 320 448 320zM440 416c0-13.25-10.75-24-24-24s-24 10.75-24 24s10.75 24 24 24S440 429.3 440 416z" fill="currentColor"></path></svg>
                                       <div class="mt-2 font-medium text-lg">Crawl</div>
                                       <div class="leading-snug text-slate-800"> Webpage with the text content </div>
                                   </a>
                               </div>

                           </div>





                               <div class="mt-25 d-flex mixin-flex-and-centre ">


                                  <div>
                                      <button id="dropdownDelayButton" data-dropdown-toggle="dropdownDelay" data-dropdown-delay="500" data-dropdown-trigger="hover" class="text-right filament-button filament-button-size-md inline-flex items-center justify-center  mt-2 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action" type="button">
                                          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                          </svg>
                                          <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                      </button>
                                      <!-- Dropdown menu -->
                                      <div id="dropdownDelay" class="z-10 hidden divide-y divide-gray-100 rounded-lg shadow w-44 z-auto border-2 bg-offwhite">
                                          <ul class="py-2 text-sm text-gray-700 sasqasw3 dark:text-gray-200" aria-labelledby="dropdownDelayButton">
                                              <li>


                                                  <a href="javascript:" wire:click="reactiveOrDeactive"  title="Click to copy" data-success-title="Copied!" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                      @if(!empty($reactive_text))
                                                          {{$reactive_text}}
                                                      @else
                                                          {{__('Activate')}}
                                                      @endif

                                                  </a>
                                              </li>
                                              <li>
                                                  <a href="javascript:" wire:click="generateNEwEmail" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{__('Generate new')}}</a>
                                              </li>
                                              <li>
                                                  <a href="{{route('lastEmail',$this->folder_id)}}" target="_blank" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{__('Last email')}}</a>
                                              </li>

                                          </ul>
                                      </div>

                                  </div>

                                   <span class=" dop bg-offwhite border-2 shadow border-radius-50 parent_mous ">

                                       <input type="text" readonly class="mous" id="GfGInput" name="" value="{{!empty($enable_email) ? $enable_email : __('Import files via email')}}">

                                     </span>
                                  <span class="info_icon" x-data="{}" x-tooltip.raw="
                                  A @‌docs2ai.com email address is a unique feature to Docs2ai that allows users to:

UPLOAD training PDFs to your folder, just send a PDF as a file attachment

REPLACE training PDFs using FileID, send a PDF as a file attachment and, in email subject add the following instruction [[replace=FileID]]

Generate an EMAIL SUMMARY of the PDF attachment, send a PDF as a file attachment and, in email subject add the following instruction [[prompt=summary]]

Generate an EMAIL RESPONSE to a custom question/prompt, send a PDF as a file attachment and, in email subject add the following instruction [[prompt=you_question]]

Note:  all instructions start with “[[“ and end with “]]”, also all email responses will be sent as an email reply.  To change the email to address for email summaries or responses, add to the instruction “|” separator and then the email address, for example, [[prompt=summary|email@email.com]]
                                  " >
                                       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                   </svg>

                                  </span>
                                   <a class="info_icon text-primary-600"  href="{{route('filament.resources.mail-activities.index',['folder_id'=>$this->folder_id])}}">Log</a>
                                   <a class="info_icon text-primary-600" wire:click="defaultReset" href="javascript:">Reset</a>

                               </div>
                               <div class="mt-4 px-4 py-3">

                               </div>
                           </div>
                       </div>

                    </section>



                </div>
            </div>
            <div class="">
                <div id="" class="m-20_ss filament-forms-section-component rounded-xl border border-gray-300 bg-white dark:border-gray-600 dark:bg-gray-800">
                    <div class="filament-forms-section-content-wrapper " wire:loading.class="loadng">
                        <div class="p-1   w-full max-w-5xl mx-auto">
                            <div  class="grid grid-cols-1   lg:grid-cols-4   filament-forms-component-container">

                                <div class="col-span-full">
                                    <div class="flex">
                                        <div class="grid grid-cols-1   lg:grid-cols-1   filament-forms-component-container">
                                            <div class="col-span-1">
                                                <div class="filament-forms-field-wrapper default_settings">

                                                    <div class="space-y-2">

                                                        <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">

                                                            <div class=" flex p-2">
                                                                IF an email with a PDF received, autometically upload and train as
                                                            </div>
                                                            <div class=" flex p-2">

                                                                <select type="text"  wire:model.defer="default_file_id" class="f_select p-2 m-2 filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500" >
                                                                    <option  {{$default_file_id == 'new' ? "selected" : ""}} value="new">{{__('NEW FILE ID')}}</option>
                                                                    @foreach($folder->contents as $content)
                                                                        <option {{$content->file_id == $default_file_id ? "selected" : ""}} value="{{$content->file_id}}" >{{$content->file_id}}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                            <div class=" flex p-2">
                                                                then
                                                            </div>
                                                            <div class=" flex p-2">
                                                                <select type="text"  wire:model="default_then" class="f_select_3 p-2 m-2 filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500" >
                                                                    <option {{$default_then == 'DO NOTHING' ? "selected" : ""}} value="DO NOTHING">DO NOTHING</option>
                                                                    <option {{$default_then == 'SUMMARIZE' ? "selected" : ""}} value="SUMMARIZE">SUMMARIZE</option>
                                                                    <option {{$default_then == 'Custom PROMPT' ? "selected" : ""}} value="Custom PROMPT">Custom PROMPT</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @if($default_then == "Custom PROMPT")
                                                            <div class=" flex p-2">
                                                                <input type="text" wire:model.defer="default_custom_prompt"  class="f_select p-2 m-2 filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                    @if($default_email_settings)
                                                        @for($i = 0;$i < count($default_email_settings);$i++)

                                                            <div class="space-y-2">

                                                                <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">

                                                                    <div class=" flex p-2 min-width-92">
                                                                        {{$i >= 1 ? "also send" : "and send"}}
                                                                    </div>
                                                                    <div class=" flex p-2">
                                                                        @if(isset($default_email_settings[$i]['from']) &&$default_email_settings[$i]['from'] == "c")
                                                                            <input type="text"  wire:model.defer="default_email_settings.{{$i}}.custom_subject" class="min-width-266 f_select2 p-2 m-2 filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500" />
                                                                        @else
                                                                            <select type="text"  wire:change="changeForm({{$i}})" wire:model="default_email_settings.{{$i}}.from" class="f_select2 p-2 m-2 filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500" >
                                                                                <option name="" id="">Select</option>
                                                                                @foreach(defultForm($default_then) as $k => $form)
                                                                                    <option value="{{$k}}" >{{$form}}</option>
                                                                                @endforeach

                                                                            </select>

                                                                        @endif

                                                                    </div>
                                                                    <div class=" flex p-2">
                                                                        to
                                                                    </div>


                                                                    @if(isset($default_email_settings[$i]['to']) && $default_email_settings[$i]['to'] == 'j')
                                                                        <div class=" flex p-2">
                                                                            <input type="text"  wire:model.defer="default_email_settings.{{$i}}.custom_email" class="f_select2 p-2 m-2 filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500" />
                                                                        </div>
                                                                    @else
                                                                        <div class=" flex p-2">
                                                                            <select type="text"  wire:model="default_email_settings.{{$i}}.to" class="f_select2 p-2 m-2 filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500" >
                                                                                <option name="" id="">Select</option>
                                                                                @foreach(defaultTo(isset($default_email_settings[$i]['from']) ? $default_email_settings[$i]['from'] : "xcs",\Illuminate\Support\Facades\Auth::id()) as $b => $to)
                                                                                    <option value="{{$b}}">{{$to}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    @endif

                                                                    <div class=" flex p-2">
                                                                        <select type="text"  wire:model.defer="default_email_settings.{{$i}}.include" class="f_select2 p-2 m-2 filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500" >
                                                                            <option name="" id="">Select</option>
                                                                            @foreach(defaultWith(isset($default_email_settings[$i]['to']) ? $default_email_settings[$i]['to'] : "xcs",\Illuminate\Support\Facades\Auth::id()) as $k => $include)
                                                                                <option value="{{$k}}">{{$include}}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </div>
                                                                    <div class=" flex p-2">
                                                                        @if($i >= 1)
                                                                            <a wire:click="delete({{$i}})" href="javascript:">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                                </svg>
                                                                            </a>
                                                                        @endif

                                                                    </div>
                                                                </div>

                                                            </div>

                                                        @endfor
                                                    @endif





                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-1 w-full mx-auto">
                            <div class="grid grid-cols-1   lg:grid-cols-4   filament-forms-component-container gap-6">
                                <div class="col-span-full">
                                    <div>
                                        <div class="grid grid-cols-1   lg:grid-cols-1   filament-forms-component-container">
                                            <div class="col-span-1 flex justify-space-between p-2">
                                                <button class="mb-10 text-right filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action" href="javascript:"
                                                        wire:click="addNew"
                                                        wire:loading.attr="disabled"
                                                >{{__('Also send')}}</button>
                                                <button class="mb-10 text-right filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action" wire:click="submitDefault">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div>
                <div class="p-6 pb-20 w-full max-w-5xl mx-auto">
                    <div class=" w-full max-w-5xl mx-auto">
                        {{$this->table}}
                    </div>
                </div>
            </div>
            <div>
                <div class="p-6 pb-20 w-full max-w-5xl mx-auto">
                    <div class="as3 w-full max-w-5xl mx-auto d-md-flex justify-space-between">


                        <div class="mt_8">
                            <a href="{{route('filament.resources.folders.edit',$this->folder_id)}}"  class="text-right filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                                {{__('Customize')}}
                            </a>
                            <a href="{{route('filament.resources.dynamic-buttons.index',['folder_id'=>$this->folder_id])}}"  class="text-right filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-derk-600 hover:bg-dark-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                                {{__('Buttons')}}
                            </a>
                            @if(\Illuminate\Support\Facades\Auth::user()->plan->max_number_of_bot == '-1')
                                <a href="{{route('filament.resources.dynamic-prompts.index',['folder_id'=>$this->folder_id])}}"  class="text-right filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-derk-600 hover:bg-dark-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                                    {{__('Prompts')}}
                                </a>
                            @endif

                            <a href="{{route('filament.resources.commands.index',['folder_id'=>$this->folder_id])}}"  class="text-right filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-derk-600 hover:bg-dark-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                                {{__('Commands')}}
                            </a>
                            <a href="{{route('filament.resources.folders.thumbLogs',$this->folder_id)}}"  class="text-right filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-gray-600 hover:bg-dark-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                                {{__('Thumbs log')}}
                            </a>

                        </div>

                        <div class="btun">

                           <div>
                               <button id="dropdownDelayButtonMove" data-dropdown-toggle="dropdownDelayMove" data-dropdown-delay="500" data-te-dropdown-position="dropup" data-dropdown-trigger="click" class="text-right filament-button filament-button-size-md inline-flex items-center justify-center  mt-2 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action" type="button">
                                   {{__('Move')}}
                                   <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                               </button>

                               @php
                                   $companies = \Illuminate\Support\Facades\Auth::user()->myCompanies;
                               @endphp
                                   <!-- Dropdown menu -->
                               <div   id="dropdownDelayMove" class=" z-10 hidden divide-y divide-gray-100 rounded-lg shadow w-44 z-auto border-2 bg-offwhite">
                                   <ul>
                                       @foreach($companies as $company)
                                           <li class="company_li">
                                               <h5><b>{{$company->name}}</b></h5>


                                               <ul>
                                                   @php
                                                       $this_folder = \App\Models\Folder::find($this->folder_id)->parent_folder_id;
                                                   @endphp
                                                   @foreach($company->projects as $project)
                                                       @if($this_folder != $project->id)
                                                           <li class="li_">
                                                               <a href="{{route('moveFolder',[$this->folder_id,$project->id])}}" wire:click="reactiveOrDeactive"  title="Click to copy" data-success-title="Copied!" class="block px-4 py-2  dark:hover:bg-gray-600 dark:hover:text-white">
                                                                   {{$project->name}}
                                                               </a>
                                                           </li>
                                                       @endif

                                                   @endforeach
                                               </ul>
                                           </li>
                                       @endforeach
                                   </ul>

                                   {{--                                <ul class="py-2 text-sm text-gray-700 sasqasw3 dark:text-gray-200" aria-labelledby="dropdownDelayButton">--}}
                                   {{--                                     @foreach($companies as $company)--}}
                                   {{--                                        <li class="company_li">--}}
                                   {{--                                            <h5><b>{{$company->name}}</b></h5>--}}


                                   {{--                                            <ul>--}}
                                   {{--                                                @php--}}
                                   {{--                                                    $this_folder = \App\Models\Folder::find($this->folder_id)->parent_folder_id;--}}
                                   {{--                                                @endphp--}}
                                   {{--                                                @foreach($company->projects as $project)--}}
                                   {{--                                                    @if($this_folder != $project->id)--}}
                                   {{--                                                        <li>--}}
                                   {{--                                                            <a href="{{route('moveFolder',[$this->folder_id,$project->id])}}" wire:click="reactiveOrDeactive"  title="Click to copy" data-success-title="Copied!" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">--}}
                                   {{--                                                                {{$project->name}}--}}
                                   {{--                                                            </a>--}}
                                   {{--                                                        </li>--}}
                                   {{--                                                    @endif--}}

                                   {{--                                                @endforeach--}}
                                   {{--                                            </ul>--}}
                                   {{--                                        </li>--}}
                                   {{--                                     @endforeach--}}



                                   {{--                                </ul>--}}
                               </div>

                           </div>


                            <div>
                                <button id="dropdownDelayCopy" data-dropdown-toggle="dropdownDelayCp" data-dropdown-delay="500" data-te-dropdown-position="dropup" data-dropdown-trigger="click" class="text-right filament-button filament-button-size-md inline-flex items-center justify-center  mt-2 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action" type="button">
                                    {{__('Copy')}}
                                    <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>

                                @php
                                    $companies = \Illuminate\Support\Facades\Auth::user()->myCompanies;

                                @endphp
                                    <!-- Dropdown menu -->
                                <div   id="dropdownDelayCp" class=" z-10 hidden divide-y divide-gray-100 rounded-lg shadow w-44 z-auto border-2 bg-offwhite">
                                    <ul>
                                        @foreach($companies as $company)
                                            <li class="company_li">
                                                <h5><b>{{$company->name}}</b></h5>


                                                <ul>
                                                    @php
                                                        $this_folder = \App\Models\Folder::find($this->folder_id)->parent_folder_id;
                                                    @endphp
                                                    @foreach($company->projects as $project)
                                                        <li class="li_">
                                                            <a href="{{route('copyFolder',[$this->folder_id,$project->id])}}" wire:click="reactiveOrDeactive"  title="Click to copy" data-success-title="Copied!" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                                {{$project->name}}
                                                            </a>
                                                        </li>

                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>

                                    {{--                                <ul class="py-2 text-sm text-gray-700 sasqasw3 dark:text-gray-200" aria-labelledby="dropdownDelayButton">--}}
                                    {{--                                     @foreach($companies as $company)--}}
                                    {{--                                        <li class="company_li">--}}
                                    {{--                                            <h5><b>{{$company->name}}</b></h5>--}}


                                    {{--                                            <ul>--}}
                                    {{--                                                @php--}}
                                    {{--                                                    $this_folder = \App\Models\Folder::find($this->folder_id)->parent_folder_id;--}}
                                    {{--                                                @endphp--}}
                                    {{--                                                @foreach($company->projects as $project)--}}
                                    {{--                                                    @if($this_folder != $project->id)--}}
                                    {{--                                                        <li>--}}
                                    {{--                                                            <a href="{{route('moveFolder',[$this->folder_id,$project->id])}}" wire:click="reactiveOrDeactive"  title="Click to copy" data-success-title="Copied!" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">--}}
                                    {{--                                                                {{$project->name}}--}}
                                    {{--                                                            </a>--}}
                                    {{--                                                        </li>--}}
                                    {{--                                                    @endif--}}

                                    {{--                                                @endforeach--}}
                                    {{--                                            </ul>--}}
                                    {{--                                        </li>--}}
                                    {{--                                     @endforeach--}}



                                    {{--                                </ul>--}}
                                </div>

                            </div>




                            <a href="{{route('delete.folder',['folder_id'=>$this->folder_id])}}"  onclick="return confirm('Are you sure you want to delete this item?');"  class="text-right filament-button filament-button-size-md inline-flex items-center justify-center  mt-2 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-red-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                                {{__('Delete bot')}}
                            </a>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    @else
        <style>
            header.filament-header:first-child{
                display: none;
            }
        </style>

        <header class="filament-header space-y-2 items-start justify-between sm:flex sm:space-y-0 sm:space-x-4  sm:rtl:space-x-reverse sm:py-4">
            <div>
                <h1 class="filament-header-heading text-2xl font-bold tracking-tight">
    <span>
                         {{$folder->name}}
                    </span>

                    <a href="{{route('filament.resources.folders.edit',$this->folder_id)}}" class="text-right filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                </h1>

            </div>


        </header>
        <div class="flex-1">
            <div>
                <div class="p-6 pb-20 w-full max-w-5xl mx-auto">
                    <section>

                        <div class="mt-4">
                            <div class="mt-4 grid sm:grid-cols-3 gap-4">
                                {{--                            <button class="px-4 py-3 rounded-lg text-left border-2 border-blue-400 bg-blue-50 transition-colors hover:border-blue-500 hover:bg-blue-100 focus:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">--}}
                                {{--                                <svg aria-hidden="true" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-800"><path d="M279.7 97.68L354.7 22.63C379.7-2.366 420.3-2.366 445.3 22.63L489.4 66.75C514.4 91.74 514.4 132.3 489.4 157.3L414.3 232.3L376.8 369.1C369.5 396.6 349 417.6 322.6 425.5L47.43 508.1C35.12 511.8 21.78 508.4 12.69 499.3C3.597 490.2 .232 476.9 3.925 464.6L86.47 189.4C94.4 162.1 115.4 142.5 142 135.2L279.7 97.68zM310.6 112L400 201.4L466.7 134.6C479.2 122.1 479.2 101.9 466.7 89.37L422.6 45.26C410.1 32.76 389.9 32.76 377.4 45.26L310.6 112zM283.3 129.9L150.5 166.1C134.5 170.5 121.9 182.7 117.1 198.6L42.7 446.7L152.9 336.5C147.2 326.1 144 315.9 144 304C144 268.7 172.7 240 208 240C243.3 240 272 268.7 272 304C272 339.3 243.3 368 208 368C196.1 368 185 364.8 175.5 359.1L65.33 469.3L313.4 394.9C329.3 390.1 341.5 377.5 345.9 361.5L382.1 228.7L283.3 129.9zM208 272C190.3 272 176 286.3 176 304C176 321.7 190.3 336 208 336C225.7 336 240 321.7 240 304C240 286.3 225.7 272 208 272z" fill="currentColor"></path></svg>--}}
                                {{--                                <div class="mt-2 font-medium text-lg">Write</div>--}}
                                {{--                                <div class="leading-snug text-slate-800"> Write or copy paste your document. </div>--}}
                                {{--                            </button>--}}
                                {{--                            <a  data-modal-target="defaultModal" data-modal-toggle="defaultModal" class="px-4 py-3 rounded-lg text-left border-2 border-purple-400 bg-purple-50 transition-colors hover:border-purple-500 hover:bg-purple-100 focus:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2">--}}
                                <a  href="{{route('project.create',$this->folder_id)}}" class="px-4 py-3 rounded-lg text-left border-2 border-purple-400 bg-purple-50 transition-colors hover:border-purple-500 hover:bg-purple-100 focus:bg-purple-100 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2">
                                    <svg aria-hidden="true" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-800"><path d="M122.6 155.1L240 51.63V368c0 8.844 7.156 16 16 16s16-7.156 16-16V51.63l117.4 104.3C392.4 158.7 396.2 160 400 160c4.406 0 8.812-1.812 11.97-5.375c5.875-6.594 5.25-16.72-1.344-22.58l-144-128c-6.062-5.406-15.19-5.406-21.25 0l-144 128C94.78 137.9 94.16 148 100 154.6S116.1 161.8 122.6 155.1zM448 320h-112c-8.836 0-16 7.162-16 16c0 8.836 7.164 16 16 16H448c17.67 0 32 14.33 32 32v64c0 17.67-14.33 32-32 32H64c-17.67 0-32-14.33-32-32v-64c0-17.67 14.33-32 32-32h112C184.8 352 192 344.8 192 336C192 327.2 184.8 320 176 320H64c-35.35 0-64 28.65-64 64v64c0 35.35 28.65 64 64 64h384c35.35 0 64-28.65 64-64v-64C512 348.7 483.3 320 448 320zM440 416c0-13.25-10.75-24-24-24s-24 10.75-24 24s10.75 24 24 24S440 429.3 440 416z" fill="currentColor"></path></svg>
                                    <div class="mt-2 font-medium text-lg">Create</div>
                                    <div class="leading-snug text-slate-800"> New content folder </div>
                                </a>


                                {{--                            <button class="cursor-not-allowed opacity-75 px-4 py-3 rounded-lg text-left border-2 border-emerald-400 bg-emerald-50 transition-colors focus:outline-none" disabled="">--}}
                                {{--                                <div class="flex items-center justify-between">--}}
                                {{--                                    <svg aria-hidden="true" viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-800">--}}
                                {{--                                        <path d="M563.3 267.2c56.2-56.2 56.2-147.3 0-203.5C509.8 10.2 423.9 7.3 366.9 57.2l-6.1 5.4c-10 8.7-11 23.9-2.3 33.9s23.9 11 33.9 2.3l6.1-5.4c38-33.2 95.2-31.3 130.9 4.4c37.4 37.4 37.4 98.1 0 135.6L416.1 346.6c-37.4 37.4-98.2 37.4-135.6 0c-35.7-35.7-37.6-92.9-4.4-130.9l4.7-5.4c8.7-10 7.7-25.1-2.3-33.9s-25.1-7.7-33.9 2.3l-4.7 5.4c-49.8 57-46.9 142.9 6.6 196.4c56.2 56.2 147.3 56.2 203.5 0L563.3 267.2zM42.7 244.8c-56.2 56.2-56.2 147.3 0 203.5c53.6 53.6 139.5 56.4 196.5 6.5l6.1-5.4c10-8.7 11-23.9 2.3-33.9s-23.9-11-33.9-2.3l-6.1 5.4c-38 33.2-95.2 31.3-130.9-4.4c-37.4-37.4-37.4-98.1 0-135.6L190 165.4c37.4-37.4 98.1-37.4 135.6 0c35.7 35.7 37.6 92.9 4.4 130.9l-5.4 6.1c-8.7 10-7.7 25.1 2.3 33.9s25.1 7.7 33.9-2.3l5.4-6.1c49.9-57 47-142.9-6.5-196.5c-56.2-56.2-147.3-56.2-203.5 0L42.7 244.8z" fill="currentColor"></path></svg>--}}
                                {{--                                </div>--}}
                                {{--                                <div class="mt-2 font-medium text-lg">Import Webpage</div>--}}
                                {{--                            </button>--}}
                            </div>
                        </div>
                    </section>


                    <div id="defaultModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden justify-center w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
                        <div class="relative justify-center w-full h-full max-w-2xl md:h-auto">
                            <!-- Modal content -->
                            <div class="relative justify-center bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <form wire:submit.prevent="create">
                                    <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            {{__('Upload files')}}
                                        </h3>
                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            <span class="sr-only">{{__('Close modal')}}</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-6 space-y-6">
                                        {{$this->form}}
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                        <button type="submit" class="text-right filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">Confirm</button>
                                        <a href="{{request()->fullUrl()}}" id="closeModal" type="button" class="closeModal text-right filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm  shadow focus:ring-white border-transparent focus:ring-offset-primary-700 filament-page-button-action">Decline</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="p-6 pb-20 w-full max-w-5xl mx-auto">
                    <div class=" w-full max-w-5xl mx-auto">
                        {{$this->table}}
                    </div>
                </div>
            </div>


        </div>
        <div>
            <div class="p-6 pb-20 w-full max-w-5xl mx-auto">
                <div class=" w-full max-w-5xl mx-auto">
                    <a href="javascript:"  onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"  wire:click="deleteProject()" class="text-right filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-danger-600 hover:bg-danger-500 focus:bg-danger-700 focus:ring-offset-primary-700 filament-page-button-action">
                        {{__('Delete project')}}
                    </a>

                </div>
            </div>
        </div>
    @endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>

{{--    {{dd($file_path)}}--}}
@if($file_path)
        <script>
            function sasa() {
                const $targetEl = document.getElementById('defaultModal');

                // options with default values
                const options = {
                    backdrop: 'dynamic',
                    backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
                    closable: true,
                    onHide: () => {
                        console.log('modal is hidden');
                    },
                    onShow: () => {
                        console.log('modal is shown');
                    },
                    onToggle: () => {
                        console.log('modal has been toggled');
                    }
                };
                const modal = new Modal($targetEl, options);

                modal.show();
            }

            sasa();
        </script>
@endif
    <script>
        function hideModal() {
            const $targetEl = document.getElementById('defaultModal');

            // options with default values
            const options = {
                backdrop: false,
                backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
                closable: false,
                onHide: () => {
                    console.log('modal is hidden');
                },
                onShow: () => {
                    console.log('modal is shown');
                },
                onToggle: () => {
                    console.log('modal has been toggled');
                }
            };
            const modal = new Modal($targetEl, options);

            modal.hide();
        }
    </script>

    <script>
        let toolt = document.querySelector('.mous');

            toolt.addEventListener("click", mous);
        function mous() {
            var copyGfGText = document.getElementById("GfGInput");
            copyGfGText.select();
            document.execCommand("copy");
            alert('Copied')
        }

    </script>



</x-filament::page>
