<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Question;
use App\QuestionCategory;
use Illuminate\Http\Request;

class QuestionsCategoryController extends Controller
{
  public function index(Request $request)
  {
    if (!empty($request->id && $request->action)) {
      $delete_question_category_id = $request->id;
      if ($request->action == 'delete') {
        $response = QuestionCategory::where('id', $delete_question_category_id)->delete();
        $response = Question::where('question_category_id', $delete_question_category_id)->delete();
        if ($response) {
          return redirect()->back()->with('message', 'Delete Successfully');
        } else {
          return redirect()->back()->with('message', 'Some Error Occure!');
        }
      }
    }
    $data['QuestionCategories'] = QuestionCategory::select()->get();
//    dd($data);
    return view('layouts/questionCatgeory/index', $data);
  }

  public function add()
  {
    return view('layouts/questionCatgeory/add');
  }

  public function insert(Request $request)
  {
    $request->validate([
      'category_name' => 'required'
    ]);
    if (!empty($request['category_name'])) {
      $data['QuestionCategory'] = QuestionCategory::select()->get();
      $present = 0;
      foreach ($data['QuestionCategory'] as $questionCategory) {
        if($questionCategory->category_name == $request->category_name){
          $present = 1;
        }
      }
      if( $present === 0){
        $question = new QuestionCategory();
        $question->category_name = $request->category_name;
        $response = $question->save();
        if ($response) {
          return redirect('/questionCategory')->with('successMsg', "Question Category Added Successfully.");
        } else {
          return redirect()->back()->with('message', 'Some Error Occure!');
        }
      } else {
        return redirect()->back()->with('message', 'Aleady Question Category Exist!');
      }
    } else {
      return redirect()->back()->with('message', 'Please Fill The Question Category Name!');
    }
  }

  public function edit(Request $request)
  {
    if (!empty($request->id && $request->action)) {
      $edited_question_category_id = $request->id;
      if ($request->action == 'edit') {
        $data['QuestionCategories'] = QuestionCategory::where('id', $edited_question_category_id)->get();
        return view('layouts/questionCatgeory/edit', $data);
      }
    }
  }

  public function update(Request $request)
  {
    $request->validate([
      'question_category_id'   => 'required',
      'question_category_name' => 'required',
    ]);
    if (!empty($request['question_category_name'])) {
      $data['Question_categories'] = QuestionCategory::select()->get();
      $present = 0;
      foreach ($data['Question_categories'] as $questionCategory) {
        if($questionCategory->category_name == $request->question_category_name){
          $present = 1;
        }
      }
//      echo 'already present: ' . $present;
      if($present <= 2){
        $response = QuestionCategory::where('id', $request->question_category_id)->update([
          'category_name' => $request->question_category_name,
        ]);
        if ($response) {
          return redirect('/questionCategory')->with('successMsg', "Question Category Edited Successfully.");
        } else {
          return redirect()->back()->with('message', 'Some Error Occure!');
        }
      } else {
        return redirect()->back()->with('message', 'Aleady Question Category Exist!');
      }
    } else {
      return redirect()->back()->with('message', 'Please Fill The Question Category!');
    }
  }
}
