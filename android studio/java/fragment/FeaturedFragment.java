package com.app.kostpink.fragment;

import static androidx.core.content.ContextCompat.getSystemService;

import android.content.ClipData;
import android.content.ClipboardManager;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.cardview.widget.CardView;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.app.kostpink.Config;
import com.app.kostpink.R;
import com.app.kostpink.SharedPrefManager;
import com.app.kostpink.activity.BookingActivity;
import com.app.kostpink.activity.RoomActivity;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.google.android.material.bottomnavigation.BottomNavigationView;

import java.util.List;

public class FeaturedFragment extends Fragment {
    CardView btnRoom, btnBooking, btnTagihan;
    SharedPrefManager sharedPrefManager;
    String nama_customer, avatar;
    TextView tv_nama;
    ImageView iv_avatar,imgVoucher;
    BottomNavigationView bottomNavigationView;
    String[]arPil={"Transfer","Cash"};


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        return inflater.inflate(R.layout.fragment_featured, container, false);
    }

    public void onViewCreated(@NonNull View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        sharedPrefManager = new SharedPrefManager(getContext());
        nama_customer = sharedPrefManager.getCustomer().getNama_customer();
        avatar = sharedPrefManager.getCustomer().getAvatar();
        tv_nama = view.findViewById(R.id.tv_nama);
        iv_avatar = view.findViewById(R.id.iv_avatar);
        imgVoucher = view.findViewById(R.id.imgVoucher);
        tv_nama.setText("Halo, " + nama_customer);
        Glide.with(getContext()).load(Config.IMAGE_URL + "customer/" + avatar).apply(new RequestOptions().override(480, 380)).into(iv_avatar);
        RecyclerView.LayoutManager mLayoutManager = new GridLayoutManager(getContext(), 1, LinearLayoutManager.HORIZONTAL, false);
         btnRoom = view.findViewById(R.id.btn_room);
        btnBooking = view.findViewById(R.id.btn_booking);
        btnTagihan = view.findViewById(R.id.btn_tagihan);
        bottomNavigationView = (BottomNavigationView) getActivity().findViewById(R.id.bottomNavigationView);
        btnRoom.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getContext(), RoomActivity.class);
                startActivity(i);
            }
        });

        btnBooking.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent i = new Intent(getContext(), BookingActivity.class);
                startActivity(i);
            }
        });
        btnTagihan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                getActivity().getSupportFragmentManager().beginTransaction().replace(R.id.fragment_container, new ActivityFragment()).commit();
                BottomNavigationView bottomNavigation = getActivity().findViewById(R.id.bottomNavigationView);
                bottomNavigation.setSelectedItemId(R.id.tagihan);
            }
        });

        imgVoucher.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String voucherCode = "PAKAISKG";

                ClipboardManager clipboard = (ClipboardManager) requireActivity().getSystemService(Context.CLIPBOARD_SERVICE);
                ClipData clip = ClipData.newPlainText("Voucher Code", voucherCode);
                clipboard.setPrimaryClip(clip);

                Toast.makeText(getActivity(), "Kode voucher disalin: " + voucherCode, Toast.LENGTH_SHORT).show();
            }
        });

    }

}