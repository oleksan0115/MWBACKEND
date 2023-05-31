@extends('layouts.common.dashboard')
@section('content')

  <div class="content-wrapper">
    <div class="content">
      <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
        @if(!empty($successMsg))
          <div class="alert alert-success"> {{ $successMsg }}</div>
        @endif
        @if(session()->has('message'))
          <div class="alert alert-success">
            {{ session()->get('message') }}
          </div>
        @endif

        <div class="d-flex justify-content-between">
          <h2 class="text-dark font-weight-medium"></h2>
        </div>
        <div class="row pt-5">
          <div class="col-sm-6">
            <h4><a href="{{URL::to('initialQuestionAdd')}}">
                <button type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>&nbsp; Add Initial Question</button>
              </a></h4>
          </div>
          <div class="table-responsive">
            <table class="table mt-3">
              <thead>
              <tr>
                <th scope="col">Sr.</th>
                <th scope="col">Question</th>
                <th scope="col">Category</th>
                <th scope="col">Action</th>
              </tr>
              </thead>
              <tbody>
                @forelse($Questions as $key => $Question)
                  <tr>
                    <td>{{--{{ $Question->id}}--}} {{ $key+1 }}</td>
                    <td>{{ $Question->question}}</td>
                    <td>
                      {{--{{ $Question->question_category_id}}--}}
                        <?php
                        foreach ($QuestionCategories as $key => $questions) {
                          /*echo '<pre>';
                          print_r($questions->question);
                          echo '</pre>';*/
                          if($Question->question_category_id == $questions->id){
                              echo $questions->category_name;
                          }
                        }
                        ?>
                    </td>
                    <td>
                      <a class="action_link" href="{{URL::to('initialQuestionEdit')}}?id={{ $Question->id}}&amp;action=edit" title="Edit">
                        <i class="fa fa-edit"></i>
                      </a>

                      &nbsp;&nbsp;

                      <a class="action_link" href="{{ request()->route()->uri }}?id={{ $Question->id}}&amp;action=delete"
                         onclick="return confirm('Are You Sure You Want To Delete?')" title="Delete">
                        <i class="fa fa-dumpster"></i>
                      </a>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="8">
                      Data Not Found
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection
