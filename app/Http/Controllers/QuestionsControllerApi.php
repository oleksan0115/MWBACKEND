<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;
use App\QuestionCategory;

class QuestionsControllerApi extends Controller
{
  protected $success_status = 200;
  protected $error_status = 500;
  protected $bad_request_status = 400;

  public function index(Request $request)
  {
    if (!empty($request->id && $request->action)) {
      $delete_question_id = $request->id;
      if ($request->action == 'delete') {
        $response = Question::where('id', $delete_question_id)->delete();
        if ($response) {
          return redirect()->back()->with('message', 'Delete Successfully');
        } else {
          return redirect()->back()->with('message', 'Some Error Occure!');
        }
      }
    }
    $data['Questions'] = Question::select()->get();
    $data['QuestionCategories'] = QuestionCategory::select()->get();
//    dd($data);
    return view('layouts/question/index', $data);
  }

  public function add()
  {
    $data['QuestionCategories'] = QuestionCategory::select()->get();
    return view('layouts/question/add', $data);
  }

  public function insert(Request $request)
  {
    $request->validate([
      'quetion_name' => 'required',
      'quetion_cat'  => 'required'
    ]);
    if (!empty($request['quetion_name'] && $request['quetion_cat'])) {
      $data['Questions'] = Question::select()->get();
      $present = 0;
      foreach ($data['Questions'] as $questions) {
        if($questions->question == $request->quetion_name){
          $present = 1;
        }
      }
      if( $present === 0){
        $question = new Question();
        $question->question             = $request->quetion_name;
        $question->question_category_id = $request->quetion_cat;
        $response = $question->save();
        if ($response) {
          return redirect('/initialQuestion')->with('successMsg', "Question Added Successfully.");
        } else {
          return redirect()->back()->with('message', 'Some Error Occure!');
        }
      } else {
        return redirect()->back()->with('message', 'Aleady Question Exist!');
      }
    } else {
      return redirect()->back()->with('message', 'Please Fill The Question!');
    }
  }

  public function edit(Request $request)
  {
    if (!empty($request->id && $request->action)) {
      $edited_question_id = $request->id;
      if ($request->action == 'edit') {
        $data['Questions'] = Question::where('id', $edited_question_id)->get();
        $data['QuestionCategories'] = QuestionCategory::select()->get();
        return view('layouts/question/edit', $data);
      }
    }
  }

  public function update(Request $request)
  {
    $request->validate([
      'quetion_id'   => 'required',
      'quetion_name' => 'required',
      'quetion_cat'  => 'required'
    ]);
    if (!empty($request['quetion_name'] && $request['quetion_cat'])) {
      $data['Questions'] = Question::select()->get();
      $present = 0;
      foreach ($data['Questions'] as $questions) {
        if($questions->question == $request->quetion_name){
          $present = $present + 1;
        }
      }
      if($present <= 2){
        $response = Question::where('id', $request->quetion_id)->update([
          'question'             => $request->quetion_name,
          'question_category_id' => $request->quetion_cat,
        ]);
        if ($response) {
          return redirect('/initialQuestion')->with('successMsg', "Question Edited Successfully.");
        } else {
          return redirect()->back()->with('message', 'Some Error Occure!');
        }
      } else {
        return redirect()->back()->with('message', 'Aleady Question Exist!');
      }
    } else {
      return redirect()->back()->with('message', 'Please Fill The Question!');
    }
  }

  public function getInitialQuestionsApi(Request $request)
  {
    $Questions = Question::select()->get();
    $data['QuestionCategories'] = QuestionCategory::select()->get();
    $initialQuestions = array();
    foreach($Questions as $key => $Question){
      $QuestionCategories = QuestionCategory::select()->where('id', $Question->question_category_id)->first();
      $sub_array['question'] = $Question->question;
      $sub_array['category_name'] = $QuestionCategories->category_name;
      array_push($initialQuestions, $sub_array);
    }
    $data = array(
      'status' => true,
      'initialQuestions' => $initialQuestions,
    );
    return response()->json($data, $this->success_status);
  }
}
