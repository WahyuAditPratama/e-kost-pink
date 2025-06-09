package com.app.kostpink.activity;

import static com.app.kostpink.Config.IMAGE_URL;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.app.kostpink.Config;
import com.app.kostpink.MainActivityAdmin;
import com.app.kostpink.R;
import com.app.kostpink.Rest.ApiClient;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.adapter.AdmTagihanAdapter;
import com.app.kostpink.adapter.TagihanAdapter;
import com.app.kostpink.model.FetchTagihanResponse;
import com.app.kostpink.model.Tagihan;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class AdmDetailBookingTagihanActivity extends AppCompatActivity {

    private SharedPrefManager sharedPrefManager;
    private String id, id_customer, id_room, start_date, end_date, harga_bulanan, status, deposit_amount, catatan, created_at, updated_at;
    private String  nama, nama_customer, nama_room, email, telepon, alamat, fitur, deskripsi, visible;

    private TextView tv_nama_customer, tv_email, tv_telepon, tv_tanggal, tv_nama_kamar, tv_harga_bulanan, tv_start_date, tv_status;
    private LinearLayout linear_status;
    private AdmTagihanAdapter tagihanAdapter;
    private List<Tagihan> tagihanList = new ArrayList<>(); // Inisialisasi tagihanList
    private RecyclerView rv1;
    private TextView tvNull;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.adm_activity_detail_booking_tagihan);

        // Inisialisasi SharedPrefManager
        sharedPrefManager = new SharedPrefManager(this);
        nama = sharedPrefManager.getUser().getNama();
        email = sharedPrefManager.getUser().getEmail();

        // Set title dan enable back button
        getSupportActionBar().setTitle("Detail Tagihan");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        // Ambil data dari Intent
        Intent i = getIntent();
        id = i.getStringExtra("id");
        id_customer = i.getStringExtra("id_customer");
        id_room = i.getStringExtra("id_room");
        start_date = i.getStringExtra("start_date");
        end_date = i.getStringExtra("end_date");
        harga_bulanan = i.getStringExtra("harga_bulanan");
        status = i.getStringExtra("status");
        deposit_amount = i.getStringExtra("deposit_amount");
        catatan = i.getStringExtra("catatan");
        created_at = i.getStringExtra("created_at");
        updated_at = i.getStringExtra("updated_at");
        nama_customer = i.getStringExtra("nama_customer");
        nama_room = i.getStringExtra("nama_room");
        email = i.getStringExtra("email");
        telepon = i.getStringExtra("telepon");
        alamat = i.getStringExtra("alamat");
        fitur = i.getStringExtra("fitur");
        deskripsi = i.getStringExtra("deskripsi");
        visible = i.getStringExtra("visible");

        // Inisialisasi TextView
        tv_nama_customer = findViewById(R.id.tv_nama_customer);
        tv_email = findViewById(R.id.tv_email);
        tv_telepon = findViewById(R.id.tv_telepon);
        tv_tanggal = findViewById(R.id.tv_tanggal);
        tv_nama_kamar = findViewById(R.id.tv_nama_kamar);
        tv_harga_bulanan = findViewById(R.id.tv_harga_bulanan);
        tv_start_date = findViewById(R.id.tv_start_date);
        tv_status = findViewById(R.id.tv_status);
        linear_status = findViewById(R.id.linear_status);
        rv1 = findViewById(R.id.rvTagihan);
        tvNull = findViewById(R.id.tv_null); // Inisialisasi TextView untuk pesan "No Activity"

        // Set data ke TextView
        tv_nama_customer.setText(nama_customer);
        tv_email.setText(email);
        tv_telepon.setText(telepon);
        tv_tanggal.setText(created_at);
        tv_nama_kamar.setText(nama_room);
        tv_harga_bulanan.setText(harga_bulanan);
        tv_start_date.setText(start_date);

        // Set status dan background
        if (status.equalsIgnoreCase("draft")) {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse));
            tv_status.setText("Draft");
        } else if (status.equalsIgnoreCase("proses")) {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse2));
            tv_status.setText("Menunggu Konfirmasi");
        } else if (status.equalsIgnoreCase("aktif")) {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse3));
            tv_status.setText("Proses Sewa");
        } else {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse5));
            tv_status.setText("Batal");
        }

        // Inisialisasi RecyclerView dan Adapter
        tagihanAdapter = new AdmTagihanAdapter(this, tagihanList);
        rv1.setLayoutManager(new LinearLayoutManager(this));
        rv1.setAdapter(tagihanAdapter);

        // Ambil data tagihan
        getData();
    }

    void getData() {
        Call<FetchTagihanResponse> call = ApiClient.getInstance().getApi().fetchTagihanAdm(id_customer);
        call.enqueue(new Callback<FetchTagihanResponse>() {
            @Override
            public void onResponse(Call<FetchTagihanResponse> call, Response<FetchTagihanResponse> response) {
                if (response.isSuccessful() && response.body() != null) {
                    if (response.body().getStatus()) {
                        tagihanList = response.body().getData();
                        tagihanAdapter.updateList(tagihanList);

                        rv1.setVisibility(View.VISIBLE);
                        tvNull.setVisibility(View.GONE);
                    } else {
                        rv1.setVisibility(View.GONE);
                        tvNull.setVisibility(View.VISIBLE);
                        Toast.makeText(AdmDetailBookingTagihanActivity.this, response.body().getMessage(), Toast.LENGTH_SHORT).show();
                    }
                } else {
                    rv1.setVisibility(View.GONE);
                    tvNull.setVisibility(View.VISIBLE);
                    Toast.makeText(AdmDetailBookingTagihanActivity.this, "Gagal mendapatkan data", Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<FetchTagihanResponse> call, Throwable t) {
                rv1.setVisibility(View.GONE);
                tvNull.setVisibility(View.VISIBLE);
                Toast.makeText(AdmDetailBookingTagihanActivity.this, t.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
    }



    public void sukses() {
        new AlertDialog.Builder(this)
                .setTitle("Sukses")
                .setMessage("Booking Berhasil Dibuat...")
                .setNeutralButton("Tutup", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dlg, int sumthin) {
                        Intent intent = new Intent(AdmDetailBookingTagihanActivity.this, MainActivityAdmin.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK | Intent.FLAG_ACTIVITY_CLEAR_TASK);
                        startActivity(intent);
                        finish();
                    }
                }).show();
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        int back = item.getItemId();
        if (back == android.R.id.home) {
            finish();
        }
        return super.onOptionsItemSelected(item);
    }
}
