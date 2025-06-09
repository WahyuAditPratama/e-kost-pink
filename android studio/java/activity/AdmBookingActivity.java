package com.app.kostpink.activity;

import android.os.Bundle;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.app.kostpink.R;
import com.app.kostpink.Rest.ApiClient;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.adapter.AdmBookingAdapter;
import com.app.kostpink.adapter.BookingAdapter;
import com.app.kostpink.model.Booking;
import com.app.kostpink.model.FetchBookingResponse;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class AdmBookingActivity extends AppCompatActivity {
    SharedPrefManager sharedPrefManager;

    private RecyclerView rvBooking;
    String id_user, nama, email,  avatar;

    private SwipeRefreshLayout swipeRefresh;
    private AdmBookingAdapter bookingAdapter;
    TextView tvNull;
    private List<Booking> listBooking = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.adm_activity_booking);
        sharedPrefManager = new SharedPrefManager(AdmBookingActivity.this);
        id_user = sharedPrefManager.getUser().getId_user();
        nama = sharedPrefManager.getUser().getNama();
        email = sharedPrefManager.getUser().getEmail();
        avatar = sharedPrefManager.getUser().getAvatar();

        tvNull=findViewById(R.id.tv_null);
        tvNull.setVisibility(View.VISIBLE);

        rvBooking = findViewById(R.id.rvBooking);
        swipeRefresh = findViewById(R.id.swipeRefresh);

        GridLayoutManager gridLayoutManager = new GridLayoutManager(this, 1);
        rvBooking.setLayoutManager(gridLayoutManager);

        // Initialize adapter with empty list
        bookingAdapter = new AdmBookingAdapter(this, listBooking);
        rvBooking.setAdapter(bookingAdapter);

        swipeRefresh.setOnRefreshListener(this::fetchBookings);

        fetchBookings();
    }

    private void fetchBookings() {
        swipeRefresh.setRefreshing(true);

        Call<FetchBookingResponse> call = ApiClient.getInstance().getApi().FetchBookingAdm();
        call.enqueue(new Callback<FetchBookingResponse>() {
            @Override
            public void onResponse(Call<FetchBookingResponse> call, Response<FetchBookingResponse> response) {
                swipeRefresh.setRefreshing(false);
                if (response.isSuccessful() && response.body() != null) {
                    listBooking = response.body().getData();
                    bookingAdapter.updateList(listBooking);
                    tvNull.setVisibility(View.GONE);

                } else {
                    Toast.makeText(AdmBookingActivity.this, "Error: " + response.message(), Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<FetchBookingResponse> call, Throwable t) {
                swipeRefresh.setRefreshing(false);
                // Menampilkan pesan error jika ada kesalahan dalam jaringan
                Toast.makeText(AdmBookingActivity.this, "Error: " + t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }
}