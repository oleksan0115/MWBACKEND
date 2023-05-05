 <aside class="left-sidebar sidebar-dark" id="left-sidebar">
          <div id="sidebar" class="sidebar sidebar-with-footer">
            <!-- Aplication Brand -->
            <div class="app-brand">
              <a href="{{URL::to('/dashboard')}}">
                <img src="resources/assets/images/logo.png" alt="mousewait">
                <span class="brand-name">Mousewait</span>
              </a>
            </div>
            <!-- begin sidebar scrollbar -->
            <div class="sidebar-left" data-simplebar style="height: 100%;">
              <!-- sidebar menu -->
              <ul class="nav sidebar-inner" id="sidebar-menu">
                

                

                
                  <li class="section-title">
                    Quick Links
                  </li>
                
                
                       <li
                   >
                    <a class="sidenav-item-link" href="{{URL::to('activeUser')}}">
                      <i class="mdi mdi-account"></i>
                      <span class="nav-text">Active Users</span>
                    </a>
                  </li>

                  <li
                   >
                    <a class="sidenav-item-link" href="{{URL::to('/reportedChat')}}">
                      <i class="mdi mdi-wechat"></i>
                      <span class="nav-text">Reported Chats</span>
                    </a>
                  </li>
                

                

                
                  <li
                   >
                    <a class="sidenav-item-link" href="{{URL::to('/reportedComment')}}">
                      <i class="mdi mdi-comment"></i>
                      <span class="nav-text">Reported Comments</span>
                    </a>
                  </li>
                  
                      <li>
                    <a class="sidenav-item-link" href="{{URL::to('/users')}}">
                      <i class="mdi mdi-account-group"></i>
                      <span class="nav-text">Users</span>
                    </a>
                  </li>
				        <li>
                    <a class="sidenav-item-link" href="{{URL::to('/leaderboard?type=d')}}">
                      <i class="mdi mdi-apps"></i>
                      <span class="nav-text">Leaderboard</span>
                    </a>
                  </li>
				  
				  		<li>
                    <a class="sidenav-item-link" href="{{URL::to('/tag')}}">
                      <i class="mdi mdi-more"></i>
                      <span class="nav-text">Tags</span>
                    </a>
					</li>
                
					<li>
                    <a class="sidenav-item-link" href="{{URL::to('/productCategory')}}">
                      <i class="mdi mdi-folder"></i>
                      <span class="nav-text">Sticker Category</span>
                    </a>
					</li>
                
             
				  
			          <li>
                    <a class="sidenav-item-link" href="{{URL::to('/products')}}">
                      <i class="mdi mdi-folder-outline"></i>
                      <span class="nav-text">Stickers</span>
                    </a>
                  </li>
                  
					<li>
                    <a class="sidenav-item-link" href="{{URL::to('/userLogo')}}">
                      <i class="mdi mdi-account-check"></i>
                      <span class="nav-text">Assign Logo TO User</span>
                    </a>
					</li>
					
						<li>
                    <a class="sidenav-item-link" href="{{URL::to('/getUserPermissionMenu')}}">
                      <i class="mdi mdi-check-all"></i>
                      <span class="nav-text">User Permission</span>
                    </a>
					</li>
                  
                  <li>
                    <a class="sidenav-item-link" href="{{URL::to('/userCreditSetting')}}">
                      <i class="mdi mdi-square-edit-outline"></i>
                      <span class="nav-text">User Credit Setting</span>
                    </a>
                  </li>
            
       
                

               
                

                
              </ul>

            </div>

         
          </div>
        </aside>

      