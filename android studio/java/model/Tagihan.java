package com.app.kostpink.model;

import com.google.gson.annotations.Expose;
import com.google.gson.annotations.SerializedName;

public class Tagihan {

    @SerializedName("id")
    @Expose
    private String id;

    @SerializedName("no_invoice")
    @Expose
    private String noInvoice;

    @SerializedName("bulan")
    @Expose
    private String bulan;

    @SerializedName("tahun")
    @Expose
    private String tahun;

    @SerializedName("due_date")
    @Expose
    private String dueDate;

    @SerializedName("nominal")
    @Expose
    private String nominal;

    @SerializedName("status")
    @Expose
    private String status;

    @SerializedName("payment_method")
    @Expose
    private String paymentMethod;

    @SerializedName("payment_date")
    @Expose
    private String paymentDate;

    @SerializedName("payment_proof")
    @Expose
    private String paymentProof;

    @SerializedName("created_at")
    @Expose
    private String createdAt;

    @SerializedName("updated_at")
    @Expose
    private String updatedAt;

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

    @SerializedName("deposit_amount")
    @Expose
    private String depositAmount;

    @SerializedName("nama_customer")
    @Expose
    private String namaCustomer;

    @SerializedName("email")
    @Expose
    private String email;

    @SerializedName("telepon")
    @Expose
    private String telepon;

    @SerializedName("tanggal_lahir")
    @Expose
    private String tanggalLahir;

    @SerializedName("jenis_kelamin")
    @Expose
    private String jenisKelamin;

    @SerializedName("alamat")
    @Expose
    private String alamat;

    @SerializedName("nama_room")
    @Expose
    private String namaRoom;

    @SerializedName("fitur")
    @Expose
    private String fitur;

    @SerializedName("deskripsi")
    @Expose
    private String deskripsi;

    // Getter dan Setter

    public String getId() { return id; }
    public void setId(String id) { this.id = id; }

    public String getNoInvoice() { return noInvoice; }
    public void setNoInvoice(String noInvoice) { this.noInvoice = noInvoice; }

    public String getBulan() { return bulan; }
    public void setBulan(String bulan) { this.bulan = bulan; }

    public String getTahun() { return tahun; }
    public void setTahun(String tahun) { this.tahun = tahun; }

    public String getDueDate() { return dueDate; }
    public void setDueDate(String dueDate) { this.dueDate = dueDate; }

    public String getNominal() { return nominal; }
    public void setNominal(String nominal) { this.nominal = nominal; }

    public String getStatus() { return status; }
    public void setStatus(String status) { this.status = status; }

    public String getPaymentMethod() { return paymentMethod; }
    public void setPaymentMethod(String paymentMethod) { this.paymentMethod = paymentMethod; }

    public String getPaymentDate() { return paymentDate; }
    public void setPaymentDate(String paymentDate) { this.paymentDate = paymentDate; }

    public String getPaymentProof() { return paymentProof; }
    public void setPaymentProof(String paymentProof) { this.paymentProof = paymentProof; }

    public String getCreatedAt() { return createdAt; }
    public void setCreatedAt(String createdAt) { this.createdAt = createdAt; }

    public String getUpdatedAt() { return updatedAt; }
    public void setUpdatedAt(String updatedAt) { this.updatedAt = updatedAt; }

    public String getIdCustomer() { return idCustomer; }
    public void setIdCustomer(String idCustomer) { this.idCustomer = idCustomer; }

    public String getIdRoom() { return idRoom; }
    public void setIdRoom(String idRoom) { this.idRoom = idRoom; }

    public String getStartDate() { return startDate; }
    public void setStartDate(String startDate) { this.startDate = startDate; }

    public String getEndDate() { return endDate; }
    public void setEndDate(String endDate) { this.endDate = endDate; }

    public String getHargaBulanan() { return hargaBulanan; }
    public void setHargaBulanan(String hargaBulanan) { this.hargaBulanan = hargaBulanan; }

    public String getDepositAmount() { return depositAmount; }
    public void setDepositAmount(String depositAmount) { this.depositAmount = depositAmount; }

    public String getNamaCustomer() { return namaCustomer; }
    public void setNamaCustomer(String namaCustomer) { this.namaCustomer = namaCustomer; }

    public String getEmail() { return email; }
    public void setEmail(String email) { this.email = email; }

    public String getTelepon() { return telepon; }
    public void setTelepon(String telepon) { this.telepon = telepon; }

    public String getTanggalLahir() { return tanggalLahir; }
    public void setTanggalLahir(String tanggalLahir) { this.tanggalLahir = tanggalLahir; }

    public String getJenisKelamin() { return jenisKelamin; }
    public void setJenisKelamin(String jenisKelamin) { this.jenisKelamin = jenisKelamin; }

    public String getAlamat() { return alamat; }
    public void setAlamat(String alamat) { this.alamat = alamat; }

    public String getNamaRoom() { return namaRoom; }
    public void setNamaRoom(String namaRoom) { this.namaRoom = namaRoom; }

    public String getFitur() { return fitur; }
    public void setFitur(String fitur) { this.fitur = fitur; }

    public String getDeskripsi() { return deskripsi; }
    public void setDeskripsi(String deskripsi) { this.deskripsi = deskripsi; }
}

