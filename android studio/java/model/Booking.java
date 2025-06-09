package com.app.kostpink.model;
import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class Booking {

    @SerializedName("id")
    @Expose
    private String id;

    @SerializedName("id_customer")
    @Expose
    private String idCustomer;

    @SerializedName("id_room")
    @Expose
    private String idRoom;

    @SerializedName("start_date")
    @Expose
    private String startDate;

    @SerializedName("end_date")
    @Expose
    private String endDate;

    @SerializedName("harga_bulanan")
    @Expose
    private String hargaBulanan;

    @SerializedName("status")
    @Expose
    private String status;

    @SerializedName("deposit_amount")
    @Expose
    private String depositAmount;

    @SerializedName("catatan")
    @Expose
    private String catatan;

    @SerializedName("created_at")
    @Expose
    private String createdAt;

    @SerializedName("updated_at")
    @Expose
    private String updatedAt;

    @SerializedName("nama_customer")
    @Expose
    private String namaCustomer;

    @SerializedName("nama_room")
    @Expose
    private String namaRoom;

    @SerializedName("email")
    @Expose
    private String email;

    @SerializedName("telepon")
    @Expose
    private String telepon;

    @SerializedName("alamat")
    @Expose
    private String alamat;

    @SerializedName("fitur")
    @Expose
    private String fitur;

    @SerializedName("deskripsi")
    @Expose
    private String deskripsi;

    // Getter and Setter methods

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getIdCustomer() {
        return idCustomer;
    }

    public void setIdCustomer(String idCustomer) {
        this.idCustomer = idCustomer;
    }

    public String getIdRoom() {
        return idRoom;
    }

    public void setIdRoom(String idRoom) {
        this.idRoom = idRoom;
    }

    public String getStartDate() {
        return startDate;
    }

    public void setStartDate(String startDate) {
        this.startDate = startDate;
    }

    public String getEndDate() {
        return endDate;
    }

    public void setEndDate(String endDate) {
        this.endDate = endDate;
    }

    public String getHargaBulanan() {
        return hargaBulanan;
    }

    public void setHargaBulanan(String hargaBulanan) {
        this.hargaBulanan = hargaBulanan;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getDepositAmount() {
        return depositAmount;
    }

    public void setDepositAmount(String depositAmount) {
        this.depositAmount = depositAmount;
    }

    public String getCatatan() {
        return catatan;
    }

    public void setCatatan(String catatan) {
        this.catatan = catatan;
    }

    public String getCreatedAt() {
        return createdAt;
    }

    public void setCreatedAt(String createdAt) {
        this.createdAt = createdAt;
    }

    public String getUpdatedAt() {
        return updatedAt;
    }

    public void setUpdatedAt(String updatedAt) {
        this.updatedAt = updatedAt;
    }

    public String getNamaCustomer() {
        return namaCustomer;
    }

    public void setNamaCustomer(String namaCustomer) {
        this.namaCustomer = namaCustomer;
    }

    public String getNamaRoom() {
        return namaRoom;
    }

    public void setNamaRoom(String namaRoom) {
        this.namaRoom = namaRoom;
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

    public String getFitur() {
        return fitur;
    }

    public void setFitur(String fitur) {
        this.fitur = fitur;
    }

    public String getDeskripsi() {
        return deskripsi;
    }

    public void setDeskripsi(String deskripsi) {
        this.deskripsi = deskripsi;
    }
}
