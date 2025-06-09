package com.app.kostpink.model;

import com.google.gson.annotations.SerializedName;
import java.util.List;

public class FetchRoomResponse {

    @SerializedName("status")
    private boolean status;

    @SerializedName("message")
    private String message;

    @SerializedName("data")
    private List<Room> data;

    // Constructor
    public FetchRoomResponse() {
    }

    // Getter dan Setter

    public boolean isStatus() {
        return status;
    }

    public void setStatus(boolean status) {
        this.status = status;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public List<Room> getData() {
        return data;
    }

    public void setData(List<Room> data) {
        this.data = data;
    }
}
