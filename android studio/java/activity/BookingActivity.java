package com.app.kostpink.activity;

import android.app.DatePickerDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.app.kostpink.MainActivity;
import com.app.kostpink.R;
import com.app.kostpink.Rest.ApiClient;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.adapter.BookingAdapter;
import com.app.kostpink.model.Booking;
import com.app.kostpink.model.BookingResponse;
import com.app.kostpink.model.FetchBookingResponse;
import com.app.kostpink.model.FetchRoomResponse;
import com.app.kostpink.model.Room;
import com.google.android.material.bottomsheet.BottomSheetDialog;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
public class BookingActivity extends AppCompatActivity {
    SharedPrefManager sharedPrefManager;

    private RecyclerView rvBooking;
    String id_customer, nama_customer, email, telepon, avatar;

    private SwipeRefreshLayout swipeRefresh;
    private BookingAdapter bookingAdapter;
    private List<Booking> listBooking = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_booking);
        sharedPrefManager = new SharedPrefManager(BookingActivity.this);
        id_customer = sharedPrefManager.getCustomer().getId_customer();
        nama_customer = sharedPrefManager.getCustomer().getNama_customer();
        email = sharedPrefManager.getCustomer().getEmail();
        avatar = sharedPrefManager.getCustomer().getAvatar();
        telepon = sharedPrefManager.getCustomer().getTelepon();

        rvBooking = findViewById(R.id.rvBooking);
        swipeRefresh = findViewById(R.id.swipeRefresh);

        GridLayoutManager gridLayoutManager = new GridLayoutManager(this, 1);
        rvBooking.setLayoutManager(gridLayoutManager);

        // Initialize adapter with empty list
        bookingAdapter = new BookingAdapter(this, listBooking);
        rvBooking.setAdapter(bookingAdapter);

        swipeRefresh.setOnRefreshListener(this::fetchBookings);

        fetchBookings();
    }

    private void fetchBookings() {
        swipeRefresh.setRefreshing(true);

        // Memanggil API untuk mengambil data room
        Call<FetchBookingResponse> call = ApiClient.getInstance().getApi().fetchBooking(id_customer);
        call.enqueue(new Callback<FetchBookingResponse>() {
            @Override
            public void onResponse(Call<FetchBookingResponse> call, Response<FetchBookingResponse> response) {
                swipeRefresh.setRefreshing(false);

                if (response.isSuccessful() && response.body() != null) {
                    // Mendapatkan list room dari response
                    listBooking = response.body().getData();
                    // Update adapter with new data
                    bookingAdapter.updateList(listBooking);
                } else {
                    // Menampilkan pesan error jika response tidak berhasil
                    Toast.makeText(BookingActivity.this, "Error: " + response.message(), Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<FetchBookingResponse> call, Throwable t) {
                swipeRefresh.setRefreshing(false);
                // Menampilkan pesan error jika ada kesalahan dalam jaringan
                Toast.makeText(BookingActivity.this, "Error: " + t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }
}