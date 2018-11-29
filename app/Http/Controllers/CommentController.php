<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function addComment(Request $request)
    {   
        $comment = new Comment();

        $comment_text = $request->comment_text;
        $status_id = $request->status_id;

        $this->validate($request,[
            'status_text' => 'required',
            'comment_text' => 'required'
        ]);

        
        $comment->comment_text = $comment_text;
        $comment->status_id = $status_id;

        if($comment->save()){
            $request->session()->flash('success-message', 'Comment has been added');
        }else{
            $request->session()->flash('error-message', 'Error occured adding comment');
        }

        return redirect()->back();
    }

    /**
     * Update the status comment
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
    */

    public function updateComment(Request $requests, Comment $comment)
    {
        $this->validate($request,[
            'comment_text' => 'required',
            'status_id' => 'required',
            'comment_id' => 'required',
        ]);

        $comment = Comment::find($request->comment_id);

        if(!$comment){
            $request->session()->flash('error-message', 'Unable to find your comment');
            return redirect()->back();
        }

        $comment->comment_text = $request->comment_text;

        if($comment->save()){
            $request->session()->flash('success-message', 'Comment has been updated');
        }else{
            $request->session()->flash('error-message', 'Error occured updating comment');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified comment 
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
    */

    public function removeComment(Request $request)
    {
        $this->validate($request,[
            'comment_id' => 'required'
        ]);

        if(Status::destroy($reuest->comment_id)){
            $request->session()->flash('success-message', 'comment has been deleted');
        }else{
            $request->session()->flash('error-message', 'Error occured deleting comment');
        }

        return redirect()->back();
    }
}
