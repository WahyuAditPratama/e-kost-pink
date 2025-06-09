package com.app.kostpink.model;

import com.google.gson.annotations.SerializedName;

public class LoginResponse {
    @SerializedName("status")
    String status;

    @SerializedName("data")
    Customer customer;
    String error;

    @SerializedName("message")
    String message;

    public LoginResponse(Customer customer, String error, String status, String message) {
        this.customer = customer;
        this.error = error;
        this.message = message;
    }


    public Customer getCustomer() {
        return customer;
    }

    public void setCustomer(Customer customer) {
        this.customer = customer;
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
