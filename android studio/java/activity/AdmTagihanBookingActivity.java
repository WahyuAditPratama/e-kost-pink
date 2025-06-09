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
import com.app.kostpink.adapter.AdmBookingTagihanAdapter;
import com.app.kostpink.model.Booking;
import com.app.kostpink.model.FetchBookingResponse;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class AdmTagihanBookingActivity extends AppCompatActivity {
    SharedPrefManager sharedPrefManager;

    private RecyclerView rvTagihan;
    String id_user, nama, email,  avatar;

    private SwipeRefreshLayout swipeRefresh;
    private AdmBookingTagihanAdapter tagihanAdapter;
    TextView tvNull;
    TextView tvlihatFile;
    private List<Booking> listTagihan = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.adm_activity_tagihan);
        sharedPrefManager = new SharedPrefManager(AdmTagihanBookingActivity.this);
        id_user = sharedPrefManager.getUser().getId_user();
        nama = sharedPrefManager.getUser().getNama();
        email = sharedPrefManager.getUser().getEmail();
        avatar = sharedPrefManager.getUser().getAvatar();

        tvNull=findViewById(R.id.tv_null);
        tvNull.setVisibility(View.VISIBLE);

        rvTagihan = findViewById(R.id.rvTagihan);
        swipeRefresh = findViewById(R.id.swipeRefresh);

        GridLayoutManager gridLayoutManager = new GridLayoutManager(this, 1);
        rvTagihan.setLayoutManager(gridLayoutManager);

        // Initialize adapter with empty list
        tagihanAdapter = new AdmBookingTagihanAdapter(this, listTagihan);
        rvTagihan.setAdapter(tagihanAdapter);

        swipeRefresh.setOnRefreshListener(this::fetchTagihans);

        fetchTagihans();
    }

    private void fetchTagihans() {
        swipeRefresh.setRefreshing(true);

        Call<FetchBookingResponse> call = ApiClient.getInstance().getApi().FetchBookingTagihanAdm();
        call.enqueue(new Callback<FetchBookingResponse>() {
            @Override
            public void onResponse(Call<FetchBookingResponse> call, Response<FetchBookingResponse> response) {
                swipeRefresh.setRefreshing(false);
                if (response.isSuccessful() && response.body() != null) {
                    listTagihan = response.body().getData();
                    tagihanAdapter.updateList(listTagihan);
                    tvNull.setVisibility(View.GONE);

                } else {
                    Toast.makeText(AdmTagihanBookingActivity.this, "Error: " + response.message(), Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<FetchBookingResponse> call, Throwable t) {
                swipeRefresh.setRefreshing(false);
                // Menampilkan pesan error jika ada kesalahan dalam jaringan
                Toast.makeText(AdmTagihanBookingActivity.this, "Error: " + t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }
}