@extends('layouts.common.dashboard') @section('content')
  <div class="content-wrapper">
    <div class="content">
      <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5 mb-6">
        @if(session()->has('message'))
          <div class="alert alert-success">
            {{ session()->get('message') }}
          </div>
        @endif
        <div class="d-flex justify-content-between">
          <h2 class="text-dark font-weight-medium"></h2>
        </div>
        <div class="d-flex">
          <a href="{{URL::to('/initialQuestion')}}">
            <button type="button" class="btn btn-sm btn-primary">
              <i class="mdi mdi-keyboard-backspace"></i>&nbsp; Back
            </button>
          </a>
          <h3 class="font-weight-bold ml-5 pl-5">Add Initial Question</h3>
        </div>
        <div class="row pt-5">
          <form action="{{ route('backend.initialQuestionInsert') }}" method="POST"class="product_table">
            @csrf
            <table width="633" border="0" cellpadding="3" cellspacing="3">
              <tr>
                <td align="center" class="page_heading_gray"></td>
              </tr>
              <tr>
                <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Question:</td>
                <td width="1"></td>
                <td width="458" align="left" valign="top">
                  <textarea name="quetion_name" id="txt_cat_desc" cols="50" rows="5" required></textarea>
                </td>
              </tr>
              <tr>
                <td width="205" align="left" valign="top" class="left_lable text-dark">&nbsp;&nbsp;Category:</td>
                <td width="1"></td>
                <td width="458" valign="top" align="left">
                  <select id="txt_cat_desc" name="quetion_cat" required>
                    @forelse($QuestionCategories as $key => $QuestionCategory)
                      <option value="{{$QuestionCategory->id}}">{{$QuestionCategory->category_name}}</option>
                    @empty
                      <option disabled>Data Not Found</option>
                    @endforelse
                  </select>
                </td>
              </tr>
              <tr>
                <td valign="top" align="center">
                  <input type="hidden" name="hid_id" id="hid_id" value=""/>
                  <button type="submit" name="submit" class="btn btn-sm btn-primary">Submit</button>
                </td>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </div>
@endsection
