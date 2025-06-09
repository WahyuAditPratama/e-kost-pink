package com.app.kostpink.model;

import com.google.gson.annotations.SerializedName;

public class DetailBookingResponse {
    @SerializedName("status")
    String status;

    @SerializedName("data")
    Booking absensi;
    String error;

    @SerializedName("message")
    String message;

    public DetailBookingResponse(Booking absensi, String error, String status, String message) {
        this.absensi = absensi;
        this.error = error;
        this.message = message;
    }


    public Booking getBooking() {
        return absensi;
    }

    public void setBooking(Booking absensi) {
        this.absensi = absensi;
    }

    public String getError() {
        return error;
    }

    public void setError(String error) {
        this.error = error;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

}
