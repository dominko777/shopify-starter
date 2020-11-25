@extends('shopify-app::layouts.default')

@section('content')
  <div id="reviews"> 
    <div class="mt-4"> 
      <div class="field is-grouped">
        <p class="control is-expanded">
          <input class="input" type="text" placeholder="Find a review">
        </p>
        <p class="control">
          <a class="button is-info">
            Search
          </a>
        </p>
      </div>
      <table class="table mt-4">
        <thead>
          <tr>
            <th>Review</th>
            <th>Photos</th>
            <th>Rating</th>
            <th>User</th>
            <th>Email</th>
            <th>Date</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Table data cell</td>
            <td>Table data cell</td>
            <td>Table data cell</td>
            <td>Table data cell</td>
            <td>Table data cell</td>
            <td>Table data cell</td>
            <td>
              <div class="action-buttons">
                <button class="button is-primary"><i class="las la-edit"></i></button>
                <button class="button is-link"><i class="las la-comment"></i></button>
                <button class="button is-warning"><i class="las la-envelope"></i></button>
                <button class="button is-danger"><i class="las la-trash"></i></button>
              </div>
            </td>
          </tr>
        </tbody>  
      </table>

      <nav class="pagination" role="navigation" aria-label="pagination">
        <a class="pagination-previous">Previous</a>
        <a class="pagination-next">Next page</a>
        <ul class="pagination-list">
          <li>
            <a class="pagination-link" aria-label="Goto page 1">1</a>
          </li>
          <li>
            <span class="pagination-ellipsis">&hellip;</span>
          </li>
          <li>
            <a class="pagination-link" aria-label="Goto page 45">45</a>
          </li>
          <li>
            <a class="pagination-link is-current" aria-label="Page 46" aria-current="page">46</a>
          </li>
          <li>
            <a class="pagination-link" aria-label="Goto page 47">47</a>
          </li>
          <li>
            <span class="pagination-ellipsis">&hellip;</span>
          </li>
          <li>
            <a class="pagination-link" aria-label="Goto page 86">86</a>
          </li>
        </ul>
      </nav>  
    </div>
  </div>
@endsection

@section('scripts')
    @parent

    <script type="text/javascript">
        var AppBridge = window['app-bridge'];
        var actions = AppBridge.actions;
        var TitleBar = actions.TitleBar;
        var Button = actions.Button;
        var Redirect = actions.Redirect;
        var titleBarOptions = {
            title: 'Dashboard',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);  
    </script>
@endsection