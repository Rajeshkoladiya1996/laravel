 <aside class="side-menu">
        <h6>GENERAL</h6>
        <ul>
            <li>
                <a href="{{route('admin')}}" class="{{(Request::is('godmode'))? 'active' : ''}}">
                    <span>
                        <svg id="group-line" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 20 20">
                            <path id="Path_363" data-name="Path 363" d="M0,0H20V20H0Z" fill="none" />
                            <path id="Path_364" data-name="Path 364"
                                d="M2,18a6.476,6.476,0,0,1,12.952,0H13.333a4.857,4.857,0,0,0-9.714,0Zm6.476-7.286a4.857,4.857,0,1,1,4.857-4.857A4.856,4.856,0,0,1,8.476,10.714Zm0-1.619A3.238,3.238,0,1,0,5.238,5.857,3.237,3.237,0,0,0,8.476,9.1Zm6.706,3A6.478,6.478,0,0,1,19,18H17.381a4.858,4.858,0,0,0-2.864-4.431l.665-1.476Zm-.557-9.14a4.454,4.454,0,0,1-1.292,8.553V9.876a2.833,2.833,0,0,0,.843-5.35Z" />
                        </svg>
                    </span>
                    <i>User Management</i>
                </a>
            </li>
            @if(Auth::user()->hasRole('super-admin'))
            <li>
              <a href="{{route('admin.userRequest')}}" class="{{(Request::is('godmode/user-request'))? 'active' : ''}}">
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                    <path fill="none" d="M0 0h24v24H0z" />
                    <path
                      d="M14 14.252v2.09A6 6 0 0 0 6 22l-2-.001a8 8 0 0 1 10-7.748zM12 13c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm0-2c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm7.418 6h3.586v2h-3.586l1.829 1.828-1.414 1.415L15.59 18l4.243-4.243 1.414 1.415L19.418 17z" />
                  </svg>
                </span>
                <i>User Request</i>
              </a>
            </li>
            
            <li>
                <a href="{{route('admin.user.reports')}}" class="{{(Request::is('godmode/user-reports'))? 'active' : ''}}">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M11 7h2v10h-2V7zm4 4h2v6h-2v-6zm-8 2h2v4H7v-4zm8-9H5v16h14V8h-4V4zM3 2.992C3 2.444 3.447 2 3.999 2H16l5 5v13.993A1 1 0 0 1 20.007 22H3.993A1 1 0 0 1 3 21.008V2.992z"/></svg>
                    </span>
                    <i>Streamer Reports</i>
                </a>
            </li>
            <li>
                <a href="{{route('admin.liveStream.reports')}}" class="{{(Request::is('godmode/live-stream-report'))? 'active' : ''}}">
                    <span>
                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-1-5h2v2h-2v-2zm0-8h2v6h-2V7z"/></svg>
                    </span>
                    <i>Reported Users/Streamers</i>
                </a>
            </li>
            @endif
            @if(Auth::user()->hasRole('super-admin'))
            <li>
                <a href="{{route('admin.subadmin')}}" class="{{(Request::is('godmode/subadmin'))? 'active' : ''}}">
                    <span>
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                        <path fill="none" d="M0 0h24v24H0z" />
                        <path
                          d="M11 14.062V20h2v-5.938c3.946.492 7 3.858 7 7.938H4a8.001 8.001 0 0 1 7-7.938zM12 13c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6z" />
                      </svg>
                    </span>
                    <i>Sub Admin</i>
                </a>
            </li>
            @endif
            <li>
                <a href="{{route('admin.liveStream')}}" class="{{(Request::is('godmode/live-stream'))? 'active' : ''}}">
                    <span>
                        <svg id="live-line" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 20 20">
                            <path id="Path_367" data-name="Path 367" d="M0,0H20V20H0Z" fill="none" />
                            <path id="Path_368" data-name="Path 368"
                                d="M13.273,4a.786.786,0,0,1,.818.75V7.9l4.265-2.737a.441.441,0,0,1,.424-.026A.372.372,0,0,1,19,5.47v9.06a.372.372,0,0,1-.22.333.441.441,0,0,1-.424-.026L14.091,12.1v3.15a.786.786,0,0,1-.818.75H1.818A.786.786,0,0,1,1,15.25V4.75A.786.786,0,0,1,1.818,4Zm-.818,1.5H2.636v9h9.818Zm4.909,2.13-3.273,2.1v.538l3.273,2.1Z" />
                            <circle id="Ellipse_21" data-name="Ellipse 21" cx="1.5" cy="1.5" r="1.5"
                                transform="translate(8 7)" />
                        </svg>
                    </span>
                    <i>Live Stream Management</i>
                </a>
            </li>
            @if(Auth::user()->hasRole('super-admin'))
            <li>
                <a href="{{route('admin.gift')}}" class="{{(Request::is('godmode/gift'))? 'active' : ''}} {{(Request::is('godmode/gift/*'))? 'active' : ''}}">
                    <span>
                        <svg id="gift-line" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 20 20">
                            <path id="Path_359" data-name="Path 359" d="M0,0H20V20H0Z" fill="none" />
                            <path id="Path_360" data-name="Path 360"
                                d="M12.661,2a3.329,3.329,0,0,1,2.885,4.994h3.778V8.657H17.659v8.322a.833.833,0,0,1-.833.832H3.5a.833.833,0,0,1-.833-.832V8.657H1V6.993H4.778a3.331,3.331,0,0,1,5.384-3.866A3.319,3.319,0,0,1,12.661,2ZM9.329,8.657h-5v7.49h5Zm6.663,0H11v7.49h5ZM7.663,3.664a1.664,1.664,0,0,0-.125,3.325l.125,0H9.329V5.329A1.665,1.665,0,0,0,7.916,3.683l-.128-.015Zm5,0A1.665,1.665,0,0,0,11,5.2l0,.125V6.993h1.666a1.665,1.665,0,0,0,1.662-1.54l0-.125A1.665,1.665,0,0,0,12.661,3.664Z"
                                transform="translate(-0.162 -0.325)" />
                        </svg>
                    </span>
                    <i>Gift Management</i>
                </a>
            </li>
            
            @endif
            
            @if(Auth::user()->hasRole('super-admin'))
            <li>
                <a href="{{route('admin.finanical')}}" class="{{(Request::is('godmode/financial'))? 'active' : ''}} {{(Request::is('godmode/finanical/*'))? 'active' : ''}}">
                    <span>
                        <svg id="money-dollar-circle-line" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            viewBox="0 0 20 20">
                            <path id="Path_361" data-name="Path 361" d="M0,0H20V20H0Z" fill="none" />
                            <path id="Path_362" data-name="Path 362"
                                d="M10,18a8,8,0,1,1,8-8A8,8,0,0,1,10,18Zm0-1.6A6.4,6.4,0,1,0,3.6,10,6.4,6.4,0,0,0,10,16.4ZM7.2,11.6h4.4a.4.4,0,1,0,0-.8H8.4a2,2,0,1,1,0-4h.8V5.2h1.6V6.8h2V8.4H8.4a.4.4,0,0,0,0,.8h3.2a2,2,0,0,1,0,4h-.8v1.6H9.2V13.2h-2Z" />
                        </svg>
                    </span>
                    <i>Financial Management</i>
                </a>
            </li>
            @endif
            <li>
                <a href="#MasterMenuCollapse" data-toggle="collapse" class="menu-collapse {{(Request::is('godmode/event')) || (Request::is('godmode/level')) || (Request::is('godmode/reward')) || (Request::is('godmode/app-settings')) || (Request::is('godmode/package')) || (Request::is('godmode/tags')) || (Request::is('godmode/profile')) || (Request::is('godmode/audit-logs'))? '' : 'collapsed'}}" aria-expanded="{{(Request::is('godmode/event')) || (Request::is('godmode/level')) || (Request::is('godmode/reward')) || (Request::is('godmode/app-settings')) || (Request::is('godmode/package')) || (Request::is('godmode/tags')) || (Request::is('godmode/profile')) || (Request::is('godmode/audit-logs'))? 'false' : 'true'}}" aria-controls="MasterMenuCollapse">
                    <span class="d-flex align-items-center justify-content-between w-100 h-auto m-0">
                        <span class="d-flex align-items-center ">
                            <span>
                                <svg viewBox="0 0 24 24" width="20" height="20">
                                    <path fill="none" d="M0 0h24v24H0z"/>
                                    <path d="M12 14v2a6 6 0 0 0-6 6H4a8 8 0 0 1 8-8zm0-1c-3.315 0-6-2.685-6-6s2.685-6 6-6 6 2.685 6 6-2.685 6-6 6zm0-2c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm2.595 7.812a3.51 3.51 0 0 1 0-1.623l-.992-.573 1-1.732.992.573A3.496 3.496 0 0 1 17 14.645V13.5h2v1.145c.532.158 1.012.44 1.405.812l.992-.573 1 1.732-.992.573a3.51 3.51 0 0 1 0 1.622l.992.573-1 1.732-.992-.573a3.496 3.496 0 0 1-1.405.812V22.5h-2v-1.145a3.496 3.496 0 0 1-1.405-.812l-.992.573-1-1.732.992-.572zM18 19.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                                </svg>
                            </span>
                            <i>Master</i>
                        </span>
                        <span class="menu-collapse-arrow" class="m-0">
                            <svg viewBox="0 0 24 24" width="20" height="20"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 13.172l4.95-4.95 1.414 1.414L12 16 5.636 9.636 7.05 8.222z"/></svg>
                        </span>
                    </span>
                </a>
                <div class="{{(Request::is('godmode/event')) || (Request::is('godmode/level')) || (Request::is('godmode/reward')) || (Request::is('godmode/app-settings')) || (Request::is('godmode/package')) || (Request::is('godmode/tags')) || (Request::is('godmode/profile')) || (Request::is('godmode/audit-logs')) || (Request::is('godmode/avtar')) || (Request::is('godmode/avtar/component'))  ? 'collapse show' : 'collapse'}} " id="MasterMenuCollapse">
                    <ul>
                        <li>
                            <a href="{{route('admin.event')}}" class="{{(Request::is('godmode/event'))? 'active' : ''}}">
                                <span>
                                    <svg id="file-list-3-line" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20">
                                        <path id="Path_365" data-name="Path 365" d="M0,0H20V20H0Z" fill="none" />
                                        <path id="Path_366" data-name="Path 366"
                                            d="M15.6,18H4.4A2.4,2.4,0,0,1,2,15.6V2.8A.8.8,0,0,1,2.8,2H14a.8.8,0,0,1,.8.8v9.6H18v3.2A2.4,2.4,0,0,1,15.6,18Zm-.8-4v1.6a.8.8,0,1,0,1.6,0V14Zm-1.6,2.4V3.6H3.6v12a.8.8,0,0,0,.8.8ZM5.2,6h6.4V7.6H5.2Zm0,3.2h6.4v1.6H5.2Zm0,3.2h4V14h-4Z" />
                                    </svg>
                                </span>
                                <i>Event Management</i>
                            </a>
                        </li>
                        @if(Auth::user()->hasRole('super-admin'))
                            <li>
                                <a href="{{route('admin.level')}}" class="{{(Request::is('godmode/level'))? 'active' : ''}} {{(Request::is('godmode/level/*'))? 'active' : ''}}">
                                    <span> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M3 12h4v9H3v-9zm14-4h4v13h-4V8zm-7-6h4v19h-4V2z"/></svg>
                                    </span>
                                    <i>Level Management</i>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.reward')}}" class="{{(Request::is('godmode/reward'))? 'active' : ''}} {{(Request::is('godmode/reward/*'))? 'active' : ''}}">
                                     <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M17 15.245v6.872a.5.5 0 0 1-.757.429L12 20l-4.243 2.546a.5.5 0 0 1-.757-.43v-6.87a8 8 0 1 1 10 0zM12 15a6 6 0 1 0 0-12 6 6 0 0 0 0 12zm0-2a4 4 0 1 1 0-8 4 4 0 0 1 0 8z"/></svg>
                                </span>
                                    <i>Reward Management</i>
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{route('admin.package')}}" class="{{(Request::is('godmode/package'))? 'active' : ''}}">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M5.33 3.271a3.5 3.5 0 0 1 4.254 4.963l10.709 10.71-1.414 1.414-10.71-10.71a3.502 3.502 0 0 1-4.962-4.255L5.444 7.63a1.5 1.5 0 1 0 2.121-2.121L5.329 3.27zm10.367 1.884l3.182-1.768 1.414 1.414-1.768 3.182-1.768.354-2.12 2.121-1.415-1.414 2.121-2.121.354-1.768zm-6.718 8.132l1.414 1.414-5.303 5.303a1 1 0 0 1-1.492-1.327l.078-.087 5.303-5.303z"/></svg>
                                    </span>
                                    <i>Package Management</i>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.app.settings')}}" class="{{(Request::is('godmode/app-settings'))? 'active' : ''}}">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M5.33 3.271a3.5 3.5 0 0 1 4.254 4.963l10.709 10.71-1.414 1.414-10.71-10.71a3.502 3.502 0 0 1-4.962-4.255L5.444 7.63a1.5 1.5 0 1 0 2.121-2.121L5.329 3.27zm10.367 1.884l3.182-1.768 1.414 1.414-1.768 3.182-1.768.354-2.12 2.121-1.415-1.414 2.121-2.121.354-1.768zm-6.718 8.132l1.414 1.414-5.303 5.303a1 1 0 0 1-1.492-1.327l.078-.087 5.303-5.303z"/></svg>
                                    </span>
                                    <i>App Settings</i>
                                </a>
                            </li>
                            
                        @endif
                        <li>
                            <a href="{{route('admin.tags')}}" class="{{(Request::is('godmode/tags'))? 'active' : ''}}">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M7.784 14l.42-4H4V8h4.415l.525-5h2.011l-.525 5h3.989l.525-5h2.011l-.525 5H20v2h-3.784l-.42 4H20v2h-4.415l-.525 5h-2.011l.525-5H9.585l-.525 5H7.049l.525-5H4v-2h3.784zm2.011 0h3.99l.42-4h-3.99l-.42 4z"/></svg>
                                </span>
                                <i>Tags</i>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.profile')}}" class="{{(Request::is('godmode/profile'))? 'active' : ''}}">
                                <span>
                                    <svg id="group-line" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20">
                                        <path id="Path_363" data-name="Path 363" d="M0,0H20V20H0Z" fill="none" />
                                        <path id="Path_364" data-name="Path 364"
                                            d="M2,18a6.476,6.476,0,0,1,12.952,0H13.333a4.857,4.857,0,0,0-9.714,0Zm6.476-7.286a4.857,4.857,0,1,1,4.857-4.857A4.856,4.856,0,0,1,8.476,10.714Zm0-1.619A3.238,3.238,0,1,0,5.238,5.857,3.237,3.237,0,0,0,8.476,9.1Z"
                                            transform="translate(2)" />
                                    </svg>
                                </span>
                                <i>Profile</i>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.auditLogs')}}" class="{{ (Request::is('godmode/audit-logs')) ? 'active' : ''}}">
                                <span>
                                    <svg id="file-list-3-line" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20">
                                        <path id="Path_365" data-name="Path 365" d="M0,0H20V20H0Z" fill="none" />
                                        <path id="Path_366" data-name="Path 366"
                                            d="M15.6,18H4.4A2.4,2.4,0,0,1,2,15.6V2.8A.8.8,0,0,1,2.8,2H14a.8.8,0,0,1,.8.8v9.6H18v3.2A2.4,2.4,0,0,1,15.6,18Zm-.8-4v1.6a.8.8,0,1,0,1.6,0V14Zm-1.6,2.4V3.6H3.6v12a.8.8,0,0,0,.8.8ZM5.2,6h6.4V7.6H5.2Zm0,3.2h6.4v1.6H5.2Zm0,3.2h4V14h-4Z" />
                                    </svg>
                                </span>
                                <i>Audit Logs</i>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.avtar')}}" class="{{(Request::is('godmode/avtar'))? 'active' : ''}}">
                                <span>
                                    <svg id="file-list-3-line" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20">
                                        <path id="Path_365" data-name="Path 365" d="M0,0H20V20H0Z" fill="none" />
                                        <path id="Path_366" data-name="Path 366"
                                            d="M15.6,18H4.4A2.4,2.4,0,0,1,2,15.6V2.8A.8.8,0,0,1,2.8,2H14a.8.8,0,0,1,.8.8v9.6H18v3.2A2.4,2.4,0,0,1,15.6,18Zm-.8-4v1.6a.8.8,0,1,0,1.6,0V14Zm-1.6,2.4V3.6H3.6v12a.8.8,0,0,0,.8.8ZM5.2,6h6.4V7.6H5.2Zm0,3.2h6.4v1.6H5.2Zm0,3.2h4V14h-4Z" />
                                    </svg>
                                </span>
                                <i>Avtar</i>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.avtar.component')}}" class="{{(Request::is('godmode/avtar/component'))? 'active' : ''}}">
                                <span>
                                    <svg id="file-list-3-line" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20">
                                        <path id="Path_365" data-name="Path 365" d="M0,0H20V20H0Z" fill="none" />
                                        <path id="Path_366" data-name="Path 366"
                                            d="M15.6,18H4.4A2.4,2.4,0,0,1,2,15.6V2.8A.8.8,0,0,1,2.8,2H14a.8.8,0,0,1,.8.8v9.6H18v3.2A2.4,2.4,0,0,1,15.6,18Zm-.8-4v1.6a.8.8,0,1,0,1.6,0V14Zm-1.6,2.4V3.6H3.6v12a.8.8,0,0,0,.8.8ZM5.2,6h6.4V7.6H5.2Zm0,3.2h6.4v1.6H5.2Zm0,3.2h4V14h-4Z" />
                                    </svg>
                                </span>
                                <i>Avtar Component</i>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </aside>