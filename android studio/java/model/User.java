package com.app.kostpink.model;

import com.google.gson.annotations.SerializedName;

public class User {

    @SerializedName("id")
    private String id_user;
    @SerializedName("nama")
    private String nama;
    @SerializedName("email")
    private String email;
    @SerializedName("username")
    private String username;
    @SerializedName("password")
    private String password;
    @SerializedName("foto")
    private String avatar;
    @SerializedName("status")
    private String status;


    public User(String id_user,
                String nama,
                String email,
                String username,
                String password,
                String avatar,
                String status) {

        this.id_user = id_user;
        this.nama = nama;
        this.email = email;
        this.password = password;
        this.avatar = avatar;
        this.status = status;
    }

    public String getId_user() {
        return id_user;
    }

    public void setId_user(String id_user) {
        this.id_user = id_user;
    }

    public String getNama() {
        return nama;
    }

    public void setNama(String nama) {
        this.nama = nama;
    }


    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

     public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getAvatar() {
        return avatar;
    }

    public void setAvatar(String avatar) {
        this.avatar = avatar;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

}
