package com.app.kostpink.activity;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Build;
import android.os.Bundle;
import android.view.MenuItem;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.app.kostpink.Config;
import com.app.kostpink.MainActivity;
import com.app.kostpink.MainActivityAdmin;
import com.app.kostpink.R;
import com.app.kostpink.Rest.ApiClient;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.databinding.ActivityDetailBookingBinding;
import com.app.kostpink.model.ConfirmBookingResponse;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class AdmDetailBookingActivity extends AppCompatActivity {

    String imageUrl = Config.IMAGE_URL;
    SharedPrefManager sharedPrefManager;


    LinearLayout linear_status, linear_konfirmasi;
    Button btn_proses;
    TextView tv_nama_customer, tv_status, tv_email, tv_telepon, tv_tanggal, tv_nama_kamar, tv_deskripsi, tv_harga_bulanan, tv_start_date, tv_end_date, tv_catatan;
    TextView tv_lihat1, tv_lihat2;
    ActivityDetailBookingBinding binding;

    String id, id_customer, nama_customer, id_room, start_date, end_date, harga_bulanan, status, deposit_amount, catatan, created_at, updated_at, nama_room, email, telepon, alamat, fitur, deskripsi;

    Spinner spinStatus;
    String[] arPil = {"terima", "tolak"};
    String visible;

    @RequiresApi(api = Build.VERSION_CODES.O)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.adm_activity_detail_booking);

        sharedPrefManager = new SharedPrefManager(this);
        nama_customer = sharedPrefManager.getCustomer().getNama_customer();
        email = sharedPrefManager.getCustomer().getEmail();
        telepon = sharedPrefManager.getCustomer().getTelepon();

        getSupportActionBar().setTitle("Detail Booking");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

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

        tv_nama_customer = findViewById(R.id.tv_nama_customer);
        tv_email = findViewById(R.id.tv_email);
        tv_telepon = findViewById(R.id.tv_telepon);
        tv_tanggal = findViewById(R.id.tv_tanggal);
        tv_nama_kamar = findViewById(R.id.tv_nama_kamar);
        tv_deskripsi = findViewById(R.id.tv_deskripsi);
        tv_harga_bulanan = findViewById(R.id.tv_harga_bulanan);
        tv_start_date = findViewById(R.id.tv_start_date);
        tv_end_date = findViewById(R.id.tv_end_date);
        tv_catatan = findViewById(R.id.tv_catatan);
        tv_status = findViewById(R.id.tv_status);

        btn_proses = findViewById(R.id.btn_proses);
        linear_status = findViewById(R.id.linear_status);
        linear_konfirmasi = findViewById(R.id.linear_konfirmasi);
        spinStatus=findViewById(R.id.spin_status);
        tv_nama_customer.setText(nama_customer);
        tv_email.setText(email);
        tv_telepon.setText(telepon);
        tv_tanggal.setText(created_at);
        tv_nama_kamar.setText(nama_room);
        tv_deskripsi.setText(deskripsi);
        tv_harga_bulanan.setText(harga_bulanan);
        tv_start_date.setText(start_date);
        tv_end_date.setText(end_date);
        tv_catatan.setText(catatan);

        ArrayAdapter<String> dataAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item, arPil);
        dataAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinStatus.setAdapter(dataAdapter);

        if (status.equalsIgnoreCase("draft")) {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse));
            tv_status.setText("Draft");
            btn_proses.setVisibility(View.GONE);
            linear_konfirmasi.setVisibility(View.GONE);
        } else if (status.equalsIgnoreCase("proses")) {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse2));
            tv_status.setText("Menunggu Konfirmasi");
            btn_proses.setVisibility(View.VISIBLE);
            linear_konfirmasi.setVisibility(View.VISIBLE);
        } else if (status.equalsIgnoreCase("aktif")) {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse3));
            tv_status.setText("Proses Sewa");
            btn_proses.setVisibility(View.GONE);
            linear_konfirmasi.setVisibility(View.GONE);
        }else{
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse5));
            tv_status.setText("Batal");
            btn_proses.setVisibility(View.GONE);
            linear_konfirmasi.setVisibility(View.GONE);
        }

        btn_proses.setOnClickListener(v -> {
            String id_booking = id;
            String status=spinStatus.getSelectedItem().toString();
            Call<ConfirmBookingResponse> call = ApiClient
                    .getInstance()
                    .getApi()
                    .confrimBookingAdm(id_booking, status);
            call.enqueue(new Callback<ConfirmBookingResponse>() {
                @Override
                public void onResponse(Call<ConfirmBookingResponse> call, Response<ConfirmBookingResponse> response) {
                    ConfirmBookingResponse ConfirmBookingResponse = response.body();
                    if (ConfirmBookingResponse.getStatus().equals("true")) {
                        sukses();
                    } else {
                        Toast.makeText(AdmDetailBookingActivity.this, ConfirmBookingResponse.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }
                @Override
                public void onFailure(Call<ConfirmBookingResponse> call, Throwable t) {
                    Toast.makeText(AdmDetailBookingActivity.this, t.getMessage(), Toast.LENGTH_SHORT).show();
                }
            });
        });
    }

    public void sukses() {
        new AlertDialog.Builder(this).setTitle("Sukses").setMessage("Booking Berhasil Dibuat...").setNeutralButton("Tutup", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dlg, int sumthin) {
                Intent intent = new Intent(AdmDetailBookingActivity.this, MainActivityAdmin.class);
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


