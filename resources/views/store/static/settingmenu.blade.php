<li class="header">STORE SETTINGS</li>

    <li class="treeview">
          <a href="#">
            <i class="fa fa-cogs"></i> <span>Store</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/store/settings/"><i class="fa fa-circle-o"></i>Naming</a></li>
            <li><a href="/store/settings/store_category"><i class="fa fa-circle-o"></i>Store Category</a></li>
            <li><a href="/store/settings/details"><i class="fa fa-circle-o"></i>Details</a></li>
            <li><a href="/store/settings/policies"><i class="fa fa-circle-o"></i>Policies</a></li>
            <li><a href="/store/settings/payment"><i class="fa fa-circle-o"></i>Payment Methods</a></li>
          </ul>
        </li>

        <li>
          <a href="/store/settings/social">
            <i class="fa fa-share-square-o"></i><span>Social Media</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>

    <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i><span>Product Related</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="/store/settings/categories"><i class="fa fa-circle-o"></i>Product Categories</a></li>
          </ul>
        </li>

<li class="treeview">
          <a href="#">
            <i class="fa fa-wrench"></i><span>Personalization</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          @if(\Session::get('privilege') == "Owner" || \Session::get('privilege') == "owner")
            <li><a href="/store/settings/layout"><i class="fa fa-circle-o"></i>Build Layout <span class="pull-right-container">
            </span></a></li>
          <li><a href="/store/settings/brand"><i class="fa fa-circle-o"></i>Brand Marks</a></li>
        @endif
          
          </ul>
        </li>

