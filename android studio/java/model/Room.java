package com.app.kostpink.model;
import com.google.gson.annotations.SerializedName;

public class Room {

    @SerializedName("id")
    private String id;

    @SerializedName("nama_room")
    private String namaRoom;

    @SerializedName("fitur")
    private String fitur;

    @SerializedName("deskripsi")
    private String deskripsi;

    @SerializedName("harga_bulanan")
    private String hargaBulanan;

    @SerializedName("gambar")
    private String gambar;

    @SerializedName("status")
    private String status;

    @SerializedName("created_at")
    private String createdAt;

    @SerializedName("updated_at")
    private String updatedAt;

    // Constructor
    public Room() {
    }

    // Getter dan Setter

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getNamaRoom() {
        return namaRoom;
    }

    public void setNamaRoom(String namaRoom) {
        this.namaRoom = namaRoom;
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

    public String getHargaBulanan() {
        return hargaBulanan;
    }

    public void setHargaBulanan(String hargaBulanan) {
        this.hargaBulanan = hargaBulanan;
    }

    public String getGambar() {
        return gambar;
    }

    public void setGambar(String gambar) {
        this.gambar = gambar;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
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
}
