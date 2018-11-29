<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;

class StatusController extends Controller
{
    /**
     * Store a newly created text status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */

    public function addText(Request $request)
    {
        $status = new Status();

        $status_text = $request->status_text;

        $this->validate($request,[
            'status_text' => 'required'
        ]);

        $status->status_text = $status_text;

        if($status->save()){
            $request->session()->flash('success-message', 'Status has been added');
        }else{
            $request->session()->flash('error-message', 'Error occured adding status');
        }

        return redirect()->back();
    }

    /**
     * Update the status text
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
    */

    public function updateText(Request $requests, Status $status)
    {
        $this->validate($request,[
            'status_text' => 'required',
            'status_id' => 'required'
        ]);

        $status = Status::find($request->status_id);

        if(!$status){
            $request->session()->flash('error-message', 'Unable to find your status');
            return redirect()->back();
        }

        $status->status_text = $request->status_text;

        if($status->save()){
            $request->session()->flash('success-message', 'Status has been updated');
        }else{
            $request->session()->flash('error-message', 'Error occured updating status');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified text status
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
    */

    public function removeText(Request $request)
    {
        $this->validate($request,[
            'status_id' => 'required'
        ]);

        if(Status::destroy($reuest->status_id)){
            $request->session()->flash('success-message', 'Status has been deleted');
        }else{
            $request->session()->flash('error-message', 'Error occured deleting status');
        }

        return redirect()->back();
    }

    /**
     * Store a newly created video status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */

    public function addVideo(Request $request)
    {
        $status = new Status();

        if($request->file('video')){
            $file = $request->file('video');
            $filename = $file->getClientOriginalName();
            $file_ext = $file->getClientOriginalExtension();
            $path = public_path().'/uploads/';

            //I didn't check for the maximum file size

            $file->move($path, $filename.'.'.$file_ext);
            $status->status_video_url = $filename.'.'.$file_ext;
        }else{
            $request->session()->flash('error-message', 'Error occured adding status');
            return redirect()->back();
        }

        if($status->save()){
            $request->session()->flash('success-message', 'Status has been added');
        }else{
            $request->session()->flash('error-message', 'Error occured adding status');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified video status
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
    */

    public function removeVideo(Request $request)
    {

        $this->validate($request,[
            'status_id' => 'required'
        ]);

        $status_id = $reuest->status_id;

        $status = Status::find($status_id);

        @unlink(public_path().'/uploads/'.$status->status_video_url);

        if(Status::destroy($reuest->status_id)){
            $request->session()->flash('success-message', 'Status has been deleted');
        }else{
            $request->session()->flash('error-message', 'Error occured deleting status');
        }

        return redirect()->back();
    }
}
