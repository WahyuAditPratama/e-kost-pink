package com.app.kostpink.model;

import com.google.gson.annotations.SerializedName;

public class Customer {

    @SerializedName("id")
    private String id_customer;
    @SerializedName("nama_customer")
    private String nama_customer;
    @SerializedName("email")
    private String email;
    @SerializedName("telepon")
    private String telepon;
    @SerializedName("alamat")
    private String alamat;
    @SerializedName("tempat_lahir")
    private String tempat_lahir;
    @SerializedName("tanggal_lahir")
    private String tanggal_lahir;
    @SerializedName("username")
    private String username;
    @SerializedName("password")
    private String password;
    @SerializedName("avatar")
    private String avatar;
    @SerializedName("status")
    private String status;


    public Customer(String id_customer, String nama_customer
            , String email, String telepon, String alamat, String  tanggal_lahir, String username, String password, String avatar, String status) {

        this.id_customer = id_customer;
        this.nama_customer = nama_customer;
        this.email = email;
        this.telepon = telepon;
        this.alamat = alamat;
        this.tanggal_lahir = tanggal_lahir;
        this.username = username;
        this.password = password;
        this.avatar = avatar;
        this.status = status;
    }

    public String getId_customer() {
        return id_customer;
    }

    public void setId_customer(String id_customer) {
        this.id_customer = id_customer;
    }

    public String getNama_customer() {
        return nama_customer;
    }

    public void setNama_customer(String nama_customer) {
        this.nama_customer = nama_customer;
    }


    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getTelepon() {
        return telepon;
    }

    public void setTelepon(String telepon) {
        this.telepon = telepon;
    }

    public String getAlamat() {
        return alamat;
    }

    public void setAlamat(String alamat) {
        this.alamat = alamat;
    }

    public String getTempat_lahir() {
        return tempat_lahir;
    }

    public void setTempat_lahir(String tempat_lahir) {
        this.tempat_lahir = tempat_lahir;
    }

    public String getTanggal_lahir() {
        return tanggal_lahir;
    }

    public void setTanggal_lahir(String tanggal_lahir) {
        this.tanggal_lahir = tanggal_lahir;
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
