package com.app.kostpink.activity;

import android.app.Activity;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.provider.MediaStore;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
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
import com.app.kostpink.R;
import com.app.kostpink.Rest.ApiClient;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.model.KonfirmasiPembayaranResponse;
import com.bumptech.glide.Glide;

import java.io.ByteArrayOutputStream;
import java.io.File;

import okhttp3.MediaType;
import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class KonfirmasiPembayaranActivity extends AppCompatActivity {
    String filePath;
    SharedPrefManager sharedPrefManager;

    LinearLayout linear_status, linear_pembayaran,linear_bukti_bayar,linearVoucher;
    TextView tv_harga_bulanan, tv_status, tv_no_invoice, tv_tanggal, tv_error;
    String id, no_invoice, bulan, tahun, nama_room, fitur, deskripsi, nama_customer, email, telepon, due_date, nominal, status, payment_method, payment_date, payment_proof, created_at, updated_at, id_customer, id_room, start_date, end_date, harga_bulanan, deposit_amount;
    String visible;
    ImageView imgUpload;
    private static final int BUFFER_SIZE = 1024 * 2;
    private static final String IMAGE_DIRECTORY = "/upload_gallery";

    Button btnUpload;
    Button btnKonfirmasi;

    Spinner spinMetodePembayaran;
    String[]arPil={"Transfer","Cash"};
    EditText txtKodeVoucher;

    String pakai_voucher;

    @RequiresApi(api = Build.VERSION_CODES.O)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_konfirmasi_pembayaran);
        sharedPrefManager = new SharedPrefManager(this);
        nama_customer = sharedPrefManager.getCustomer().getNama_customer();
        email = sharedPrefManager.getCustomer().getEmail();
        telepon = sharedPrefManager.getCustomer().getTelepon();

        getSupportActionBar().setTitle("Konfirmasi Pembayaran");
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);

        Intent i = getIntent();
        id = i.getStringExtra("id");
        no_invoice = i.getStringExtra("no_invoice");
        bulan = i.getStringExtra("bulan");
        tahun = i.getStringExtra("tahun");
        due_date = i.getStringExtra("due_date");
        nominal = i.getStringExtra("nominal");
        status = i.getStringExtra("status");
        payment_method = i.getStringExtra("payment_method");
        payment_date = i.getStringExtra("payment_date");
        payment_proof = i.getStringExtra("payment_proof");
        created_at = i.getStringExtra("created_at");
        updated_at = i.getStringExtra("updated_at");
        id_customer = i.getStringExtra("id_customer");
        id_room = i.getStringExtra("id_room");
        start_date = i.getStringExtra("start_date");
        end_date = i.getStringExtra("end_date");
        harga_bulanan = i.getStringExtra("harga_bulanan");
        deposit_amount = i.getStringExtra("deposit_amount");
        nama_customer = i.getStringExtra("nama_customer");
        email = i.getStringExtra("email");
        telepon = i.getStringExtra("telepon");
        nama_room = i.getStringExtra("nama_room");
        fitur = i.getStringExtra("fitur");
        deskripsi = i.getStringExtra("deskripsi");
        visible = i.getStringExtra("visible");

        pakai_voucher="belum";


        tv_no_invoice = findViewById(R.id.tv_no_invoice);
        tv_harga_bulanan = findViewById(R.id.tv_harga_bulanan);
        tv_tanggal = findViewById(R.id.tv_tanggal);
        tv_status = findViewById(R.id.tv_status);
        btnKonfirmasi = findViewById(R.id.btn_proses);
        linear_status = findViewById(R.id.linear_status);
        linear_pembayaran = findViewById(R.id.linear_pembayaran);
        linear_bukti_bayar = findViewById(R.id.linear_bukti_bayar);
        spinMetodePembayaran = findViewById(R.id.spin_metode_pembayaran);
        linearVoucher=findViewById(R.id.linear_voucher);
        txtKodeVoucher = findViewById(R.id.txt_kode_voucher);

        tv_error = findViewById(R.id.tv_error);
        imgUpload=findViewById(R.id.imgUpload);
        btnUpload=findViewById(R.id.btnUpload);


        tv_no_invoice.setText(no_invoice);
        tv_harga_bulanan.setText(harga_bulanan);
        tv_tanggal.setText(due_date);

        if (status.equalsIgnoreCase("pending")) {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse));
            tv_status.setText("Menunggu Pembayaran");
            btnKonfirmasi.setVisibility(View.VISIBLE);
            linear_pembayaran.setVisibility(View.VISIBLE);

        } else if (status.equalsIgnoreCase("proses")) {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse2));
            tv_status.setText("Menunggu Konfirmasi");
            btnKonfirmasi.setVisibility(View.GONE);
            linear_pembayaran.setVisibility(View.GONE);

        } else if (status.equalsIgnoreCase("paid")) {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse3));
            tv_status.setText("Sudah Dibayar");
            btnKonfirmasi.setVisibility(View.GONE);
            linear_pembayaran.setVisibility(View.GONE);
        } else {
            linear_status.setBackground(getDrawable(R.drawable.bg_ellipse5));
            tv_status.setText("Batal");
            btnKonfirmasi.setVisibility(View.GONE);
            linear_pembayaran.setVisibility(View.GONE);
        }


        if (pakai_voucher.equalsIgnoreCase("sudah")) {
            linearVoucher.setVisibility(View.GONE);
        } else {
            linearVoucher.setVisibility(View.VISIBLE);
        }


        ArrayAdapter<String> dataAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_spinner_item,arPil);
        dataAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinMetodePembayaran.setAdapter(dataAdapter);

        spinMetodePembayaran.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                String selectedMethod = parent.getItemAtPosition(position).toString();
                if (selectedMethod.equals("Cash")) {
                    linear_bukti_bayar.setVisibility(View.GONE);
                } else {
                    linear_bukti_bayar.setVisibility(View.VISIBLE);
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });

        btnUpload = findViewById(R.id.btnUpload);
        btnUpload.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                selectFile(KonfirmasiPembayaranActivity.this);
            }
        });

        imgUpload.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                preview(filePath);
            }
        });



        btnKonfirmasi.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Confirm();
            }
        });

    }

    private void selectFile(Context context) {
        final CharSequence[] options = {"Take Photo", "Choose File", "Cancel"};

        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        builder.setTitle("Choose your documents");

        builder.setItems(options, new DialogInterface.OnClickListener() {

            @Override
            public void onClick(DialogInterface dialog, int item) {

                if (options[item].equals("Take Photo")) {
                    Intent takePicture = new Intent(MediaStore.ACTION_IMAGE_CAPTURE);
                    startActivityForResult(takePicture, 0);

                } else if (options[item].equals("Choose File")) {
                    Intent pickFile = new Intent(Intent.ACTION_PICK, MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
                    startActivityForResult(pickFile, 1);

                } else if (options[item].equals("Cancel")) {
                    dialog.dismiss();
                }
            }
        });
        builder.show();
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (resultCode != RESULT_CANCELED) {
            switch (requestCode) {
                case 0:
                    if (resultCode == RESULT_OK && data != null) {
                        Bitmap selectedImage = (Bitmap) data.getExtras().get("data");
                        // img_avatar.setImageBitmap(selectedImage);
                        Uri tempUri = getImageUri(getApplicationContext(), selectedImage);
                        filePath = getRealPathFromURI(tempUri);
                        tv_error.setText(filePath);

                        //     btn_update_avatar.setVisibility(View.VISIBLE);
                    }

                    break;
                case 1:
                    if (resultCode == Activity.RESULT_OK) {
                        assert data != null;
                        Uri ambilImage = data.getData();
                        String[] filePathColumn = {MediaStore.Images.Media.DATA};
                        if (ambilImage != null) {
                            Cursor cursor = getContentResolver().query(ambilImage,
                                    filePathColumn, null, null, null);
                            if (cursor != null) {
                                cursor.moveToFirst();

                                int columnIndex = cursor.getColumnIndex(filePathColumn[0]);
                                filePath = cursor.getString(columnIndex);
                                tv_error.setText(filePath);
                                cursor.close();
                            }
                        }

                    }
                    break;
            }
        }
    }

    public Uri getImageUri(Context inContext, Bitmap inImage) {
        ByteArrayOutputStream bytes = new ByteArrayOutputStream();
        inImage.compress(Bitmap.CompressFormat.JPEG, 100, bytes);
        String path = MediaStore.Images.Media.insertImage(inContext.getContentResolver(), inImage, "Title", null);
        return Uri.parse(path);
    }


    public String getRealPathFromURI(Uri uri) {
        String path = "";
        if (getContentResolver() != null) {
            Cursor cursor = getContentResolver().query(uri, null, null, null, null);
            if (cursor != null) {
                cursor.moveToFirst();
                int idx = cursor.getColumnIndex(MediaStore.Images.ImageColumns.DATA);
                path = cursor.getString(idx);
                cursor.close();
            }
        }
        return path;
    }


    private void preview(String filePath) {


        if (filePath == null) {

            AlertDialog.Builder builder1 = new AlertDialog.Builder(KonfirmasiPembayaranActivity.this);
            builder1.setTitle("Bukti Pembayaran");
            final View lihatHasil = getLayoutInflater().inflate(R.layout.preview_image_activity, null);
            ImageView imageView = lihatHasil.findViewById(R.id.iv_previewImage);
            builder1.setView(lihatHasil);
            builder1.setMessage("Anda belum melampirkan File");
            imageView.setVisibility(View.GONE);
            builder1.setPositiveButton("Tutup", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialogInterface, int i) {
                    dialogInterface.dismiss();
                }
            });

            builder1.show();

        } else {
            AlertDialog.Builder builder1 = new AlertDialog.Builder(KonfirmasiPembayaranActivity.this);
            builder1.setTitle("Bukti Pembayaran");
            final View lihatHasil = getLayoutInflater().inflate(R.layout.preview_image_activity, null);
            ImageView imageView = lihatHasil.findViewById(R.id.iv_previewImage);
            builder1.setView(lihatHasil);

            imageView.setVisibility(View.VISIBLE);

            Glide.with(KonfirmasiPembayaranActivity.this).load(filePath)
                    .fitCenter().into(imageView);

            builder1.setPositiveButton("Tutup", new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialogInterface, int i) {
                    dialogInterface.dismiss();
                }
            });

            builder1.show();
        }

    }

    private void Confirm() {
        String metode_pembayaran = spinMetodePembayaran.getSelectedItem().toString();
        String kode_voucher = txtKodeVoucher.getText().toString();

        if (!kode_voucher.isEmpty() && !kode_voucher.equals("PAKAISKG")) {
            Toast.makeText(KonfirmasiPembayaranActivity.this, "Kode voucher yang anda masukkan tidak sesuai.", Toast.LENGTH_SHORT).show();
            return; // Exit the method early if the voucher code is invalid
        }


            if (metode_pembayaran.equals("Cash")) {
            Call<KonfirmasiPembayaranResponse> call = ApiClient
                    .getInstance()
                    .getApi()
                    .konfirmasiPembayaran(null, // No file to upload
                            RequestBody.create(id, MediaType.parse("text/plain")),
                            RequestBody.create(metode_pembayaran, MediaType.parse("text/plain")),
                            RequestBody.create(kode_voucher, MediaType.parse("text/plain")));

            call.enqueue(new Callback<KonfirmasiPembayaranResponse>() {
                @Override
                public void onResponse(Call<KonfirmasiPembayaranResponse> call, Response<KonfirmasiPembayaranResponse> response) {
                    KonfirmasiPembayaranResponse konfirmasiPembayaranResponse = response.body();
                    if (konfirmasiPembayaranResponse != null && konfirmasiPembayaranResponse.getStatus().equals("true")) {
                        sukses();
                    } else {
                        Toast.makeText(KonfirmasiPembayaranActivity.this, konfirmasiPembayaranResponse.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }

                @Override
                public void onFailure(Call<KonfirmasiPembayaranResponse> call, Throwable t) {
                    Toast.makeText(KonfirmasiPembayaranActivity.this, t.getMessage(), Toast.LENGTH_SHORT).show();
                }
            });

        } else {
            if (filePath != null) {
                File imageFile = new File(filePath);
                RequestBody reqBody = RequestBody.create(MediaType.parse("multipart/form-file"), imageFile);
                MultipartBody.Part partImage = MultipartBody.Part.createFormData("payment_proof", imageFile.getName(), reqBody);

                Call<KonfirmasiPembayaranResponse> call = ApiClient
                        .getInstance()
                        .getApi()
                        .konfirmasiPembayaran(partImage,
                                RequestBody.create(id, MediaType.parse("text/plain")),
                                RequestBody.create(metode_pembayaran, MediaType.parse("text/plain")),
                                RequestBody.create(kode_voucher, MediaType.parse("text/plain")));

                call.enqueue(new Callback<KonfirmasiPembayaranResponse>() {
                    @Override
                    public void onResponse(Call<KonfirmasiPembayaranResponse> call, Response<KonfirmasiPembayaranResponse> response) {
                        KonfirmasiPembayaranResponse konfirmasiPembayaranResponse = response.body();
                        if (konfirmasiPembayaranResponse != null && konfirmasiPembayaranResponse.getStatus().equals("true")) {
                            sukses();
                        } else {
                            Toast.makeText(KonfirmasiPembayaranActivity.this, konfirmasiPembayaranResponse.getMessage(), Toast.LENGTH_SHORT).show();
                        }
                    }

                    @Override
                    public void onFailure(Call<KonfirmasiPembayaranResponse> call, Throwable t) {
                        Toast.makeText(KonfirmasiPembayaranActivity.this, t.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                });
            } else {
                Toast.makeText(KonfirmasiPembayaranActivity.this, "Please upload a payment proof.", Toast.LENGTH_SHORT).show();
            }
        }
    }



    public void sukses() {
        new AlertDialog.Builder(this).setTitle("Sukses").setMessage("Reservasi Berhasil Dibuat...").setNeutralButton("Tutup", new DialogInterface.OnClickListener() {
            public void onClick(DialogInterface dlg, int sumthin) {
                Intent intent = new Intent(KonfirmasiPembayaranActivity.this, SuksesPembayaranActivity.class);
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

