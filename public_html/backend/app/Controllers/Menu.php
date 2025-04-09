<?php

namespace App\Controllers;

class Menu extends BaseController
{
    // zeigt die ansicht zum hochladen von neuem content
    public function newContentUpload()
    {
        $data['title'] = 'new upload';
        return view('newContentUpload', $data);
    }

    // zeigt eine tabelle aller contents
    public function allContent()
    {
        $data['title'] = 'all content';
        return view('allContent', $data);
    }

    // zeigt eine tabelle aller playlists
    public function allPlaylists()
    {
        $data['title'] = 'allplaylists';
        return view('allPlaylists', $data);
    }

    // zeigt eine tabelle aller schedules
    public function allSchedules()
    {
        $data['title'] = 'allSchedules';
        return view('allSchedules', $data);
    }

    public function devices()
    {
        $data['title'] = 'devices';
        return view('devices', $data);
    }

    public function newPlaylist()
    {
        $data['title'] = 'newPlaylist';
        return view('newPlaylist', $data);
    }

    public function newSchedule()
    {
        $data['title'] = 'newSchedule';
        return view('newSchedule', $data);
    }

    public function statistic()
    {
        $data['title'] = 'statistic';
        return view('statistic', $data);
    }

    public function users()
    {
        $data['title'] = 'users';
        return view('users', $data);
    }

    public function client()
    {
        $data['title'] = 'client';
        return view('client_view', $data);
    }

    public function users_new()
    {
        $data['title'] = 'users_new';
        return view('users_new', $data);
    }

    public function users_table()
    {
        $data['title'] = 'users_table';
        return view('users_table', $data);
    }

    public function playlistBearbeiten()
    {
        $data['title'] = 'playlistBearbeiten';
        return view('allPlaylist_bearbeiten', $data);
    }

    
}

